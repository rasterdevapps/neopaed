<style type="text/css">/*Dasii*/
.template_faq {
    background: #edf3fe none repeat scroll 0 0;
}
.panel-group {
    background: #fff none repeat scroll 0 0;
    border-radius: 3px;
    box-shadow: 0 5px 30px 0 rgba(0, 0, 0, 0.04);
    margin-bottom: 0;
    padding: 30px;
}
#accordion .panel {
    border: medium none;
    border-radius: 0;
    box-shadow: none;
    padding: 10px 0 15px 26px;
}
#accordion .panel-heading {
    border-radius: 30px;
    padding: 0;
}
#accordion .panel-title a {
    background: #ffb900 none repeat scroll 0 0;
    border: 1px solid transparent;
    border-radius: 30px;
    color: #fff;
    display: block;
    font-size: 18px;
    font-weight: 600;
    padding: 12px 20px 12px 50px;
    position: relative;
    transition: all 0.3s ease 0s;
}
#accordion .panel-title a.collapsed {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #ddd;
    color: #333;
}
#accordion .panel-title a::after, #accordion .panel-title a.collapsed::after {
    background: #ffb900 none repeat scroll 0 0;
    border: 1px solid transparent;
    border-radius: 50%;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.58);
    color: #fff;
    content: "";
    font-family: fontawesome;
    font-size: 25px;
    height: 55px;
    left: -20px;
    line-height: 55px;
    position: absolute;
    text-align: center;
    top: -5px;
    transition: all 0.3s ease 0s;
    width: 55px;
}
#accordion .panel-title a.collapsed::after {
    background: #fff none repeat scroll 0 0;
    border: 1px solid #ddd;
    box-shadow: none;
    color: #333;
    content: "";
}
#accordion .panel-body {
    background: transparent none repeat scroll 0 0;
    border-top: medium none;
    padding: 20px 25px 10px 9px;
    position: relative;
}
#accordion .panel-body p {
    border-left: 1px dashed #8c8c8c;
    padding-left: 25px;
}
@media(max-width: 637px)
{
    .panel-group
    {
        padding: 0px !important;
    }
}
.mental-scales-table td {
    vertical-align: middle !important;
}
.motor-scales-table td {
    vertical-align: middle !important;
}
.btn.box-selection {
    background-color: transparent;
    color: white;
    border: 1px solid white;
}
.btn.box-selection.no-action {
    color: black;
}
.bootbox.bootbox-scale .modal-dialog {
    width: 250px;
}
.bootbox.bootbox-scale .bootbox-body {
    font-size: 24px;
}
.bootbox-scale .close {
    display: none;
}
.dasii-container .reset {
    padding: 0px 3px;
    box-shadow: none;
    background-color: transparent;
    border: 0px;
    color: #000000;
}
.remarks-delay {
    background-color: #f0ad4e !important;
    color: white !important;
}
.remarks-more-delay {
    background-color: #bd362f !important;
    color: white !important;   
}
#dasii_tab tr.color-white-must td {
    color: white !important;
}
.label-info {
    background-color: #34a7c8;
}
.label-warning {
    background-color: #fa9f1e;
}

.transparent-bg {
    background-color: transparent !important;
}
.border-none {
    border: none !important;
}
.bg-primary {
    background-color: #3968c6 !important;
}
.bg-danger {
    background-color: rgb(255 0 0 / 50%) !important;
}
.bg-success {
    background-color: rgb(0 128 0 / 50%) !important;
}
.custom-border-bottom {
    border-bottom: 5px solid white !important;
}
.custom-border-right {
    border-right: 5px solid white !important;        
}
</style>
<div class="row">
    <div class="col-xs-12 text-right back-to-screeening">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO DASII</button>
    </div>
</div>
<div class="row dasii-container">
    <div class="col-md-12">
        {!! Form::hidden('dasii_age') !!}
        {!! Form::hidden('dasii_mental_questions_count', count($dasii_mental_questions)) !!}
        {!! Form::hidden('dasii_motor_questions_count', count($dasii_motor_questions)) !!}
        <div class="col-md-10 col-md-offset-1">
            <div class="table-responsive">
                <h3 class="text-center">DASII <span class="pull-right">Age - <b id="dasii-age-label"></b></span></h3>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="collapsed">
                                    MENTAL SCALES 
                                    <span class="color-black font-normal pull-right plr-15" id="mental_quotient">Metal Development Quotient: <b>{!! @$results->mental_development_quotient !!}</b></span>
                                    <span class="color-black font-normal pull-right plr-15" id="mental_age">Metal Development Age: <b>{!! @$results->mental_development_age !!}</b></span>
                                </a>
                                {!! Form::hidden('mental_development_age') !!}
                                {!! Form::hidden('mental_development_quotient') !!}
                                {!! Form::hidden('mental_prior_pass') !!}
                                {!! Form::hidden('mental_rest_fail') !!}
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered mental-scales-table border-none">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="valign-middle transparent-bg border-none"></th>
                                            <th rowspan="2" class="valign-middle transparent-bg border-none"></th>
                                            <th rowspan="2" class="valign-middle transparent-bg border-none"></th>
                                            <th colspan="3" class="valign-middle">AGE PLACEMENT</th>
                                            <th rowspan="2" class="valign-middle">CONTENT CLUSTER</th>
                                        </tr>
                                        <tr>
                                            <th>50%</th>
                                            <th>3%</th>
                                            <th>97%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dasii_mental_questions as $mental_key => $mental_value)
                                        <tr data-percentile="{{ $mental_value['fiftieth_percentile'] }}" data-question-no="{{$mental_value['question_number']}}">
                                            <td class="bg-primary border-none custom-border-bottom plr-must-0 ptb-must-0">
                                                {!! Form::hidden('mentalanswer['.$mental_value['question_number'].']', null, ['data-val-copy'=>@$results->mentalanswer[$mental_value['question_number']]]) !!}
                                                <div class="ptb-10">{{ $mental_value['question_number'] }}.</div>
                                            </td>
                                            <td class="bg-primary border-none custom-border-bottom plr-must-0 ptb-must-0 align-left">
                                                <div class="ptb-10">{{ $mental_value['question'] }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></div>
                                            </td>
                                            <td class="bg-primary border-none custom-border-bottom plr-must-0 ptb-must-0 custom-border-right">
                                                <div class="ptb-10">
                                                    <span class="btn box-selection selected-yes" data-option="Yes">Yes</span><span class="btn box-selection selected-no" data-option="No">No</span>
                                                </div>
                                            </td>
                                            <td class="p-must-0">{{ $mental_value['fiftieth_percentile'] }}</td>
                                            <td class="p-must-0">{{ $mental_value['third_percentile'] }}</td>
                                            <td class="p-must-0">{{ $mental_value['ninety_seventh_percentile'] }}</td>
                                            <td class="p-must-0">{{ $mental_value['content_cluster'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="collapsed">
                                    MOTOR SCALES 
                                    <span class="color-black font-normal pull-right plr-15" id="motor_quotient">Motor Development Quotient: <b>{!! @$results->motor_development_quotient !!}</b></span>
                                    <span class="color-black font-normal pull-right plr-15" id="motor_age">Motor Development Age: <b>{!! @$results->motor_development_age !!}</b></span>
                                </a>
                                {!! Form::hidden('motor_development_age') !!}
                                {!! Form::hidden('motor_development_quotient') !!}
                                {!! Form::hidden('motor_prior_pass') !!}
                                {!! Form::hidden('motor_rest_fail') !!}
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered motor-scales-table border-none">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="valign-middle transparent-bg border-none"></th>
                                            <th rowspan="2" class="valign-middle transparent-bg border-none"></th>
                                            <th rowspan="2" class="valign-middle transparent-bg border-none"></th>
                                            <th colspan="3" class="valign-middle">AGE PLACEMENT</th>
                                            <th rowspan="2" class="valign-middle">CONTENT CLUSTER</th>
                                        </tr>
                                        <tr>
                                            <th>50%</th>
                                            <th>3%</th>
                                            <th>97%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dasii_motor_questions as $motor_key => $motor_value)
                                        <tr data-percentile="{{ $motor_value['fiftieth_percentile'] }}" data-question-no="{{$motor_value['question_number']}}">                                        
                                            <td class="bg-primary border-none custom-border-bottom plr-must-0 ptb-must-0">
                                                {!! Form::hidden('motoranswer['.$motor_value['question_number'].']', null, ['data-val-copy'=>@$results->motoranswer[$motor_value['question_number']]]) !!}
                                                <div class="ptb-10">{{ $motor_value['question_number'] }}.</div>
                                            </td>
                                            <td class="bg-primary border-none custom-border-bottom plr-must-0 ptb-must-0 align-left">
                                                <div class="ptb-10">{{ $motor_value['question'] }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></div>
                                            </td>
                                            <td class="bg-primary border-none custom-border-bottom plr-must-0 ptb-must-0 custom-border-right">
                                                <div class="ptb-10">
                                                    <span class="btn box-selection selected-yes" data-option="Yes">Yes</span><span class="btn box-selection selected-no" data-option="No">No</span>
                                                </div>
                                            </td>
                                            <td class="p-must-0">{{ $motor_value['fiftieth_percentile'] }}</td>
                                            <td class="p-must-0">{{ $motor_value['third_percentile'] }}</td>
                                            <td class="p-must-0">{{ $motor_value['ninety_seventh_percentile'] }}</td>
                                            <td class="p-must-0">{{ $motor_value['content_cluster'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseTwo" class="collapsed">
                                    CLUSTER
                                    <i class="fa fa-info-circle pull-right" id="cluster_range" title="{{ @$results->cluster_range }}"></b></i>
                                </a>
                                {!! Form::hidden('cluster_range') !!}
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                @php
                                $motor_cluster_1 = collect($dasii_motor_questions)->where('content_cluster', 'I')->pluck('question_number');
                                $motor_cluster_1 = json_encode($motor_cluster_1);

                                $motor_cluster_2 = collect($dasii_motor_questions)->where('content_cluster', 'II')->pluck('question_number');
                                $motor_cluster_2 = json_encode($motor_cluster_2);

                                $motor_cluster_3 = collect($dasii_motor_questions)->where('content_cluster', 'III')->pluck('question_number');
                                $motor_cluster_3 = json_encode($motor_cluster_3);

                                $motor_cluster_4 = collect($dasii_motor_questions)->where('content_cluster', 'IV')->pluck('question_number');
                                $motor_cluster_4 = json_encode($motor_cluster_4);

                                $motor_cluster_5 = collect($dasii_motor_questions)->where('content_cluster', 'V')->pluck('question_number');
                                $motor_cluster_5 = json_encode($motor_cluster_5);

                                $mental_cluster_1 = collect($dasii_mental_questions)->where('content_cluster', 'I')->pluck('question_number');
                                $mental_cluster_1 = json_encode($mental_cluster_1);

                                $mental_cluster_2 = collect($dasii_mental_questions)->where('content_cluster', 'II')->pluck('question_number');
                                $mental_cluster_2 = json_encode($mental_cluster_2);

                                $mental_cluster_3 = collect($dasii_mental_questions)->where('content_cluster', 'III')->pluck('question_number');
                                $mental_cluster_3 = json_encode($mental_cluster_3);

                                $mental_cluster_4 = collect($dasii_mental_questions)->where('content_cluster', 'IV')->pluck('question_number');
                                $mental_cluster_4 = json_encode($mental_cluster_4);

                                $mental_cluster_5 = collect($dasii_mental_questions)->where('content_cluster', 'V')->pluck('question_number');
                                $mental_cluster_5 = json_encode($mental_cluster_5);

                                $mental_cluster_6 = collect($dasii_mental_questions)->where('content_cluster', 'VI')->pluck('question_number');
                                $mental_cluster_6 = json_encode($mental_cluster_6);

                                $mental_cluster_7 = collect($dasii_mental_questions)->where('content_cluster', 'VII')->pluck('question_number');
                                $mental_cluster_7 = json_encode($mental_cluster_7);

                                $mental_cluster_8 = collect($dasii_mental_questions)->where('content_cluster', 'VIII')->pluck('question_number');
                                $mental_cluster_8 = json_encode($mental_cluster_8);

                                $mental_cluster_9 = collect($dasii_mental_questions)->where('content_cluster', 'IX')->pluck('question_number');
                                $mental_cluster_9 = json_encode($mental_cluster_9);

                                $mental_cluster_10 = collect($dasii_mental_questions)->where('content_cluster', 'X')->pluck('question_number');
                                $mental_cluster_10 = json_encode($mental_cluster_10);
                                @endphp
                                <table class="table table-bordered" style="margin: auto; width: auto;">
                                    <thead>
                                        <tr>
                                            <td>Cluster No.</td>
                                            <td>Mental clusters and no. of items</td>
                                            <td>Items Passed</td>
                                            <td>PR {{ Form::hidden('mental_cluster', json_encode(@$mental_cluster)) }}</td>
                                            <td>Remarks</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>I</td>
                                            <td>Cognizance - Visual (25) {{ Form::hidden('mental_cluster_1') }} {{ Form::hidden('mental_cluster_question_1', $mental_cluster_1) }}</td>
                                            <td class="input-width-small" id="mental_cluster_1">{{ @$results->mental_cluster_1 }}</td>
                                            <td id="mental_cluster_pr_1">{{ Form::hidden('mental_cluster_pr_1') }}<span>{!! @$results->mental_cluster_pr_1 !!}</span></td>
                                            <td id="mental_cluster_remarks_1" class="mental-remarks-status">{{ Form::hidden('mental_cluster_remarks_1') }}<span>{{ @$results->mental_cluster_remarks_1 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>II</td>
                                            <td>Cognizance - Auditory (7) {{ Form::hidden('mental_cluster_2') }} {{ Form::hidden('mental_cluster_question_2', $mental_cluster_2) }}</td>
                                            <td class="input-width-small" id="mental_cluster_2">{{ @$results->mental_cluster_2 }}</td>
                                            <td id="mental_cluster_pr_2">{{ Form::hidden('mental_cluster_pr_2') }}<span>{!! @$results->mental_cluster_pr_2 !!}</span></td>
                                            <td id="mental_cluster_remarks_2" class="mental-remarks-status">{{ Form::hidden('mental_cluster_remarks_2') }}<span>{{ @$results->mental_cluster_remarks_2 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>III</td>
                                            <td>Reaching, manipulating and exploring (36) {{ Form::hidden('mental_cluster_3') }} {{ Form::hidden('mental_cluster_question_3', $mental_cluster_3) }}</td>
                                            <td class="input-width-small" id="mental_cluster_3">{{ @$results->mental_cluster_3 }}</td>
                                            <td id="mental_cluster_pr_3">{{ Form::hidden('mental_cluster_pr_3') }}<span>{!! @$results->mental_cluster_pr_3 !!}</span></td>
                                            <td id="mental_cluster_remarks_3" class="mental-remarks-status">{{ Form::hidden('mental_cluster_remarks_3') }}<span>{{ @$results->mental_cluster_remarks_3 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>IV</td>
                                            <td>Memory (11) {{ Form::hidden('mental_cluster_4') }} {{ Form::hidden('mental_cluster_question_4', $mental_cluster_4) }}</td>
                                            <td class="input-width-small" id="mental_cluster_4">{{ @$results->mental_cluster_4 }}</td>
                                            <td id="mental_cluster_pr_4">{{ Form::hidden('mental_cluster_pr_4') }}<span>{!! @$results->mental_cluster_pr_4 !!}</span></td>
                                            <td id="mental_cluster_remarks_4" class="mental-remarks-status">{{ Form::hidden('mental_cluster_remarks_4') }}<span>{{ @$results->mental_cluster_remarks_4 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>V</td>
                                            <td>Social interaction and imitalive behaviour (22) {{ Form::hidden('mental_cluster_5') }} {{ Form::hidden('mental_cluster_question_5', $mental_cluster_5) }}</td>
                                            <td class="input-width-small" id="mental_cluster_5">{{ @$results->mental_cluster_5 }}</td>
                                            <td id="mental_cluster_pr_5">{{ Form::hidden('mental_cluster_pr_5') }}<span>{!! @$results->mental_cluster_pr_5 !!}</span></td>
                                            <td id="mental_cluster_remarks_5" class="mental-remarks-status">{{ Form::hidden('mental_cluster_remarks_5') }}<span>{{ @$results->mental_cluster_remarks_5 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>VI</td>
                                            <td>Language - Vocalisation, speech and communication (11) {{ Form::hidden('mental_cluster_6') }} {{ Form::hidden('mental_cluster_question_6', $mental_cluster_6) }}</td>
                                            <td class="input-width-small" id="mental_cluster_6">{{ @$results->mental_cluster_6 }}</td>
                                            <td id="mental_cluster_pr_6">{{ Form::hidden('mental_cluster_pr_6') }}<span>{!! @$results->mental_cluster_pr_6 !!}</span></td>
                                            <td id="mental_cluster_remarks_6" class="mental-remarks-status">{{ Form::hidden('mental_cluster_remarks_6') }}<span>{{ @$results->mental_cluster_remarks_6 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>VII</td>
                                            <td>Language - Vocabulary and comprehension (18) {{ Form::hidden('mental_cluster_7') }} {{ Form::hidden('mental_cluster_question_7', $mental_cluster_7) }}</td>
                                            <td class="input-width-small" id="mental_cluster_7">{{ @$results->mental_cluster_7 }}</td>
                                            <td id="mental_cluster_pr_7">{{ Form::hidden('mental_cluster_pr_7') }}<span>{!! @$results->mental_cluster_pr_7 !!}</span></td>
                                            <td id="mental_cluster_remarks_7" class="mental-remarks-status">{{ Form::hidden('mental_cluster_remarks_7') }}<span>{{ @$results->mental_cluster_remarks_7 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>VIII</td>
                                            <td>Understanding relationship (18) {{ Form::hidden('mental_cluster_8') }} {{ Form::hidden('mental_cluster_question_8', $mental_cluster_8) }}</td>
                                            <td class="input-width-small" id="mental_cluster_8">{{ @$results->mental_cluster_8 }}</td>
                                            <td id="mental_cluster_pr_8">{{ Form::hidden('mental_cluster_pr_8') }}<span>{!! @$results->mental_cluster_pr_8 !!}</span></td>
                                            <td id="mental_cluster_remarks_8" class="mental-remarks-status">{{ Form::hidden('mental_cluster_remarks_8') }}<span>{{ @$results->mental_cluster_remarks_8 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>IX</td>
                                            <td>Differentiation by use, shapes and movements (8) {{ Form::hidden('mental_cluster_9') }} {{ Form::hidden('mental_cluster_question_9', $mental_cluster_9) }}</td>
                                            <td class="input-width-small" id="mental_cluster_9">{{ @$results->mental_cluster_9 }}</td>
                                            <td id="mental_cluster_pr_9">{{ Form::hidden('mental_cluster_pr_9') }}<span>{!! @$results->mental_cluster_pr_9 !!}</span></td>
                                            <td id="mental_cluster_remarks_9" class="mental-remarks-status">{{ Form::hidden('mental_cluster_remarks_9') }}<span>{{ @$results->mental_cluster_remarks_9 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>X</td>
                                            <td>Manual dexterity (7) {{ Form::hidden('mental_cluster_10') }} {{ Form::hidden('mental_cluster_question_10', $mental_cluster_10) }}</td>
                                            <td class="input-width-small" id="mental_cluster_10">{{ @$results->mental_cluster_10 }}</td>
                                            <td id="mental_cluster_pr_10">{{ Form::hidden('mental_cluster_pr_10') }}<span>{!! @$results->mental_cluster_pr_10 !!}</span></td>
                                            <td id="mental_cluster_remarks_10" class="mental-remarks-status">{{ Form::hidden('mental_cluster_remarks_10') }}<span>{{ @$results->mental_cluster_remarks_10 }}</span></td>
                                        </tr>
                                        <tr><td colspan="5"></td></tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <td>Cluster No.</td>
                                            <td>Motor clusters and no. of items</td>
                                            <td>Items Passed</td>
                                            <td>PR {{ Form::hidden('motor_cluster', json_encode(@$motor_cluster)) }}</td>
                                            <td>Remarks</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>I</td>
                                            <td>Neck control (7) {{ Form::hidden('motor_cluster_1') }} {{ Form::hidden('motor_cluster_question_1', $motor_cluster_1) }}</td>
                                            <td class="input-width-small" id="motor_cluster_1">{{ @$results->motor_cluster_1 }}</td>
                                            <td id="motor_cluster_pr_1">{{ Form::hidden('motor_cluster_pr_1') }}<span>{!! @$results->motor_cluster_pr_1 !!}</span></td>
                                            <td id="motor_cluster_remarks_1" class="motor-remarks-status">{{ Form::hidden('motor_cluster_remarks_1') }}<span>{{ @$results->motor_cluster_remarks_1 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>II</td>
                                            <td>Body control (23) {{ Form::hidden('motor_cluster_2') }} {{ Form::hidden('motor_cluster_question_2', $motor_cluster_2) }}</td>
                                            <td class="input-width-small" id="motor_cluster_2">{{ @$results->motor_cluster_2 }}</td>
                                            <td id="motor_cluster_pr_2">{{ Form::hidden('motor_cluster_pr_2') }}<span>{!! @$results->motor_cluster_pr_2 !!}</span></td>
                                            <td id="motor_cluster_remarks_2" class="motor-remarks-status">{{ Form::hidden('motor_cluster_remarks_2') }}<span>{{ @$results->motor_cluster_remarks_2 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>III</td>
                                            <td>Locomotion - I (10) {{ Form::hidden('motor_cluster_3') }} {{ Form::hidden('motor_cluster_question_3', $motor_cluster_3) }}</td>
                                            <td class="input-width-small" id="motor_cluster_3">{{ @$results->motor_cluster_3 }}</td>
                                            <td id="motor_cluster_pr_3">{{ Form::hidden('motor_cluster_pr_3') }}<span>{!! @$results->motor_cluster_pr_3 !!}</span></td>
                                            <td id="motor_cluster_remarks_3" class="motor-remarks-status">{{ Form::hidden('motor_cluster_remarks_3') }}<span>{{ @$results->motor_cluster_remarks_3 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>IV</td>
                                            <td>Locomotion - II (13) {{ Form::hidden('motor_cluster_4') }} {{ Form::hidden('motor_cluster_question_4', $motor_cluster_4) }}</td>
                                            <td class="input-width-small" id="motor_cluster_4">{{ @$results->motor_cluster_4 }}</td>
                                            <td id="motor_cluster_pr_4">{{ Form::hidden('motor_cluster_pr_4') }}<span>{!! @$results->motor_cluster_pr_4 !!}</span></td>
                                            <td id="motor_cluster_remarks_4" class="motor-remarks-status">{{ Form::hidden('motor_cluster_remarks_4') }}<span>{{ @$results->motor_cluster_remarks_4 }}</span></td>
                                        </tr>
                                        <tr>
                                            <td>V</td>
                                            <td>Manipulation (14) {{ Form::hidden('motor_cluster_5') }} {{ Form::hidden('motor_cluster_question_5', $motor_cluster_5) }}</td>
                                            <td class="input-width-small" id="motor_cluster_5">{{ @$results->motor_cluster_5 }}</td>
                                            <td id="motor_cluster_pr_5">{{ Form::hidden('motor_cluster_pr_5') }}<span>{!! @$results->motor_cluster_pr_5 !!}</span></td>
                                            <td id="motor_cluster_remarks_5" class="motor-remarks-status">{{ Form::hidden('motor_cluster_remarks_5') }}<span>{{ @$results->motor_cluster_remarks_5 }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group row mt-15">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('mental_cluster_interpretation','Mental:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input custom-select-tag">
                                        {!! Form::text('mental_cluster_interpretation', null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row mt-15">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('motor_cluster_interpretation','Motor:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input custom-select-tag">
                                        {!! Form::text('motor_cluster_interpretation', null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-15">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('dasii_interpretation','Interpretation:') !!}
                    </div>
                    <div class="col-md-9 custom-input custom-select-tag">
                        {!! Form::text('dasii_interpretation', null,['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('dasii_interpretation_others','Others:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::textarea('dasii_interpretation_others', null,['class'=>'form-control', 'rows'=>2]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO DASII</button>
    </div>
</div>
<script type="text/javascript">
var continous_question_count = 10;
var reset_trigger = false;
var mental_question_no = parseInt($('input[name="dasii_mental_questions_count"]').val());
var motor_question_no = parseInt($('input[name="dasii_motor_questions_count"]').val());
$('input[name="dasii_age"]').on('change', function() {
    $('input[name^="mentalanswer"]').each(function() {
        var question_no = $(this).parents('tr').attr('data-question-no');
        var value = $(this).val();
        value = value.toLowerCase();
        $('.mental-scales-table tr[data-question-no="' + question_no + '"]').find('.box-selection.selected-' + value).addClass('selection-highlighter');
    });
    $('input[name^="motoranswer"]').each(function() {
        var question_no = $(this).parents('tr').attr('data-question-no');
        var value = $(this).val();
        value = value.toLowerCase();
        $('.motor-scales-table tr[data-question-no="' + question_no + '"]').find('.box-selection.selected-' + value).addClass('selection-highlighter');
    });
    var mental_prior_pass = $('input[name="mental_prior_pass"]').val();
    var motor_prior_pass = $('input[name="motor_prior_pass"]').val();
    var mental_rest_fail = $('input[name="mental_rest_fail"]').val();
    var motor_rest_fail = $('input[name="motor_rest_fail"]').val();
    $('.mental-scales-table tr[data-question-no="' + mental_prior_pass + '"] td.custom-border-bottom').addClass('bg-success');
    $('.motor-scales-table tr[data-question-no="' + motor_prior_pass + '"] td.custom-border-bottom').addClass('bg-success');
    $('.mental-scales-table tr[data-question-no="' + mental_rest_fail + '"] td.custom-border-bottom').addClass('bg-danger');
    $('.motor-scales-table tr[data-question-no="' + motor_rest_fail + '"] td.custom-border-bottom').addClass('bg-danger');
    for (var i = 1; i < mental_prior_pass; i++) {
        $('input[name^="mentalanswer[' + i + ']"]').attr('data-val-copy', 'Yes');
    }
    for (var i = 1; i < motor_prior_pass; i++) {
        $('input[name^="motoranswer[' + i + ']"]').attr('data-val-copy', 'Yes');
    }
});
var mental_age = 0;
$('.mental-scales-table .box-selection').on('click', function() {
    if (!reset_trigger) {
        $(this).parents('tr').find('.box-selection').removeClass('selection-highlighter');
        $(this).addClass('selection-highlighter');
        var value = $(this).attr('data-option');
    } else {
        var value = '';
        reset_trigger = false;
    }
    var question_no = $(this).parents('tr').attr('data-question-no');
    question_no = parseInt(question_no);
    $('input[name="mentalanswer[' + question_no + ']"]').val(value).attr('data-val-copy', value);
    $('.mental-scales-table tr td.bg-danger').removeClass('bg-danger').addClass('bg-primary');
    $('.mental-scales-table tr td.bg-success').removeClass('bg-success').addClass('bg-primary');
    var yes_count = $('.mental-scales-table input[name^="mentalanswer"][value="Yes"]').length;
    var no_count = $('.mental-scales-table input[name^="mentalanswer"][value="No"]').length;
    if (yes_count >= 10) {
        $('.mental-scales-table input[name^="mentalanswer"][value="Yes"]').each(function() {
            var age = 0;
            var pass_answer_count = 0;
            var pass_start_at = $(this).parents('tr').attr('data-question-no');
            pass_start_at = parseInt(pass_start_at);
            var pass_end_at = pass_start_at + yes_count;
            var prior_pass = 0;
            for (var p = pass_start_at; p <= pass_end_at; p++) {
                age = $('input[name="mentalanswer[' + p + ']"]').val();
                if (age == 'Yes') {
                    pass_answer_count += 1;
                } else {
                    pass_answer_count = 0;
                    pass_start_at = p + 1;
                }
                if (pass_answer_count == continous_question_count) {
                    $('input[name="mental_prior_pass"]').val(pass_start_at);
                    $('.mental-scales-table tr[data-question-no="' + pass_start_at + '"] td.custom-border-bottom').removeClass('bg-primary').removeClass('bg-danger').addClass('bg-success');
                    for (var i = 1; i < pass_start_at; i++) {
                        $('input[name="mentalanswer[' + i + ']"]').attr('data-val-copy', 'Yes');
                    }
                    prior_pass = pass_start_at;
                    p = pass_end_at;
                }
            }
            if ($('.mental-scales-table tr[data-question-no="' + mental_question_no + '"] td.custom-border-bottom').find('.box-selection').hasClass('selection-highlighter')) {
                lastQuestion(question_no);
            }
            if (prior_pass > 0) {
                return false;
            }
        });
    }
    if (no_count >= 10) {
        $('.mental-scales-table input[name^="mentalanswer"][value="No"]').each(function() {
            var current_selected_question_no = parseInt($(this).parents('tr').attr('data-question-no'));
            var start = current_selected_question_no;
            var end = current_selected_question_no + 9;
            var wrong_answer_count = 0;
            for (var i = start; i <= end; i++) {
                var selected_value = $('input[name="mentalanswer[' + i + ']"]').val();
                if (selected_value == 'No') {
                    wrong_answer_count += 1;
                } else {
                    wrong_answer_count = 0;
                }
            }
            if (wrong_answer_count == continous_question_count) {
                $('input[name="mental_rest_fail"]').val(end);
                $('.mental-scales-table tr[data-question-no="' + end + '"] td.bg-primary').addClass('bg-danger').removeClass('bg-primary');
                $('.mental-scales-table tr[data-question-no="' + end + '"] td.bg-success').addClass('bg-danger').removeClass('bg-success');
                mental_age = $('.mental-scales-table input[data-val-copy="Yes"]').length;
                mental_age = $('.mental-scales-table tr[data-question-no="' + mental_age + '"]').attr('data-percentile');
                if (typeof mental_age === 'undefined') {
                    mental_age = 0;
                }
                if (question_no <= end) {
                    bootboxmsg(mental_age, 'Mental');
                }
                return false;
            }
            if ($('.mental-scales-table tr[data-question-no="' + mental_question_no + '"] td.custom-border-bottom').find('.box-selection').hasClass('selection-highlighter')) {
                lastQuestion(question_no);
            }
        });
    }
    setTimeout(function() {
        var dasii_age = $('input[name="dasii_age"]').val();
        $('input[name="mental_development_age"]').val(mental_age);
        $('#mental_age b').html(mental_age);
        var mental_quotient = (mental_age / dasii_age) * 100;
        mental_quotient = parseFloat(mental_quotient).toFixed(2);
        $('input[name="mental_development_quotient"]').val(mental_quotient);
        if (mental_quotient > 0) {
            $('input[name="mental_development_quotient"]').trigger('change');
        }
    }, 150);
});

function lastQuestion(question_no) {
    setTimeout(function() {
        if (question_no == mental_question_no && $('.mental-scales-table tr td.custom-border-bottom').hasClass('bg-success') && !$('.mental-scales-table tr td.custom-border-bottom').hasClass('bg-danger')) {
            mental_age = $('.mental-scales-table input[data-val-copy="Yes"]').length;
            mental_age = $('.mental-scales-table tr[data-question-no="' + mental_age + '"]').attr('data-percentile');
            if (typeof mental_age === 'undefined') {
                mental_age = 0;
            }
            bootboxmsg(mental_age, 'Mental');
            return false;
        }
    }, 100);
}
$(document).on('change', 'input[name="mental_development_quotient"]', function() {
    var mental_quotient = $('input[name="mental_development_quotient"]').val();
    var mental_quotient_status = ' (> average)';
    if (mental_quotient != '') {
        $('#mental-quotient').removeClass('label-danger').removeClass('label-warning').removeClass('label-success').removeClass('hide');
        var status_color = 'label-info'
        if (mental_quotient < 70) {
            status_color = 'label-danger';
            mental_quotient_status = ' (Delay)';
        } else if (mental_quotient >= 70 && mental_quotient < 85) {
            status_color = 'label-warning';
            mental_quotient_status = ' (< Average)';
        } else if (mental_quotient >= 85 && mental_quotient < 115) {
            status_color = 'label-success';
            mental_quotient_status = ' (Average)';
        }
        $('#mental-quotient').addClass(status_color).addClass('color-white-must');
        $('#mental-quotient .quotient').html(mental_quotient + mental_quotient_status);
    }
    $('#mental_quotient b').html(mental_quotient);
});
var motor_age = 0;
$('.motor-scales-table .box-selection').on('click', function() {
    if (!reset_trigger) {
        $(this).parents('tr').find('.box-selection').removeClass('selection-highlighter');
        $(this).addClass('selection-highlighter');
        var value = $(this).attr('data-option');
    } else {
        var value = '';
        reset_trigger = false;
    }
    var question_no = $(this).parents('tr').attr('data-question-no');
    question_no = parseInt(question_no);
    $('input[name="motoranswer[' + question_no + ']"]').val(value).attr('data-val-copy', value);
    $('.motor-scales-table tr td.bg-danger').removeClass('bg-danger').addClass('bg-primary');
    $('.motor-scales-table tr td.bg-success').removeClass('bg-success').addClass('bg-primary');
    var yes_count = $('.motor-scales-table input[name^="motoranswer"][value="Yes"]').length;
    var no_count = $('.motor-scales-table input[name^="motoranswer"][value="No"]').length;
    if (yes_count >= 10) {
        $('.motor-scales-table input[name^="motoranswer"][value="Yes"]').each(function() {
            var age = 0;
            var pass_answer_count = 0;
            var pass_start_at = $(this).parents('tr').attr('data-question-no');
            pass_start_at = parseInt(pass_start_at);
            var pass_end_at = pass_start_at + yes_count - 1;
            var prior_pass = 0;
            for (var p = pass_start_at; p <= pass_end_at; p++) {
                age = $('input[name="motoranswer[' + p + ']"]').val();
                if (age == 'Yes') {
                    pass_answer_count += 1;
                } else {
                    pass_answer_count = 0;
                    pass_start_at = p + 1;
                }
                if (pass_answer_count == continous_question_count) {
                    $('input[name="motor_prior_pass"]').val(pass_start_at);
                    $('.motor-scales-table tr[data-question-no="' + pass_start_at + '"] td.custom-border-bottom').removeClass('bg-primary').removeClass('bg-danger').addClass('bg-success');
                    for (var i = 1; i < pass_start_at; i++) {
                        $('input[name="motoranswer[' + i + ']"]').attr('data-val-copy', 'Yes');
                    }
                    prior_pass = pass_start_at;
                    p = pass_end_at;
                }
            }
            if ($('.motor-scales-table tr[data-question-no="' + motor_question_no + '"] td.custom-border-bottom').find('.box-selection').hasClass('selection-highlighter')) {
                motorLastQuestion(question_no);
            }
            if (prior_pass > 0) {
                return false;
            }
        });
    }
    if (no_count >= 10) {
        $('.motor-scales-table input[name^="motoranswer"][value="No"]').each(function() {
            var current_selected_question_no = parseInt($(this).parents('tr').attr('data-question-no'));
            var start = current_selected_question_no;
            var end = current_selected_question_no + 9;
            var wrong_answer_count = 0;
            for (var i = start; i <= end; i++) {
                var selected_value = $('input[name="motoranswer[' + i + ']"]').val();
                if (selected_value == 'No') {
                    wrong_answer_count += 1;
                } else {
                    wrong_answer_count = 0;
                }
            }
            if (wrong_answer_count == continous_question_count) {
                $('input[name="motor_rest_fail"]').val(end);
                $('.motor-scales-table tr[data-question-no="' + end + '"] td.bg-primary').addClass('bg-danger').removeClass('bg-primary');
                $('.motor-scales-table tr[data-question-no="' + end + '"] td.bg-success').addClass('bg-danger').removeClass('bg-success');
                motor_age = $('.motor-scales-table input[data-val-copy="Yes"]').length;
                motor_age = $('.motor-scales-table tr[data-question-no="' + motor_age + '"]').attr('data-percentile');
                if (typeof motor_age === 'undefined') {
                    motor_age = 0;
                }
                if (question_no <= end) {
                    bootboxmsg(motor_age, 'Motor');
                }
                return false;
            }
            if ($('.motor-scales-table tr[data-question-no="' + motor_question_no + '"] td.custom-border-bottom').find('.box-selection').hasClass('selection-highlighter')) {
                motorLastQuestion(question_no);
            }
        });
    }
    setTimeout(function() {
        var dasii_age = $('input[name="dasii_age"]').val();
        $('input[name="motor_development_age"]').val(motor_age);
        $('#motor_age b').html(motor_age);
        var motor_quotient = (motor_age / dasii_age) * 100;
        motor_quotient = parseFloat(motor_quotient).toFixed(2);
        $('input[name="motor_development_quotient"]').val(motor_quotient);
        if (motor_quotient > 0) {
            $('input[name="motor_development_quotient"]').val(motor_quotient).trigger('change');
        }
    }, 150);
});

function motorLastQuestion(question_no) {
    setTimeout(function() {
        if (question_no == motor_question_no && $('.motor-scales-table tr td.custom-border-bottom').hasClass('bg-success') && !$('.motor-scales-table tr td.custom-border-bottom').hasClass('bg-danger')) {
            motor_age = $('.motor-scales-table input[data-val-copy="Yes"]').length;
            motor_age = $('.motor-scales-table tr[data-question-no="' + motor_age + '"]').attr('data-percentile');
            if (typeof motor_age === 'undefined') {
                motor_age = 0;
            }
            bootboxmsg(motor_age, 'Motor');
            return false;
        }
    }, 100);
}
$(document).on('change', 'input[name="motor_development_quotient"]', function() {
    var motor_quotient = $('input[name="motor_development_quotient"]').val();
    var motor_quotient_status = ' (> average)';
    if (motor_quotient != '') {
        $('#motor-quotient').removeClass('label-danger').removeClass('label-warning').removeClass('label-success').removeClass('hide');
        var status_color = 'label-info'
        if (motor_quotient < 70) {
            status_color = 'label-danger';
            motor_quotient_status = ' (Delay)';
        } else if (motor_quotient >= 70 && motor_quotient < 85) {
            status_color = 'label-warning';
            motor_quotient_status = ' (< Average)';
        } else if (motor_quotient >= 85 && motor_quotient < 115) {
            status_color = 'label-success';
            motor_quotient_status = ' (Average)';
        }
        $('#motor-quotient').addClass(status_color).addClass('color-white-must');
        $('#motor-quotient .quotient').html(motor_quotient + motor_quotient_status);
    }
    $('#motor_quotient b').html(motor_quotient);
});

function bootboxmsg(age, type) {
    bootbox.dialog({
        message: type + " Age is <b>" + age + "</b>",
        buttons: {
            ok: {
                label: '<i class="fa fa-check"></i> OK',
                className: 'btn-primary',
                callback: function() {
                    if (type == 'Motor') {
                        for (var i = 1; i <= 5; i++) {
                            var motor_cluster = $('input[name="motor_cluster_question_' + i + '"]').val();
                            motor_cluster = JSON.parse(motor_cluster);
                            var motor_cluster_pass_val_count = 0;
                            $.each(motor_cluster, function(key, value) {
                                var answer = $('input[name="motoranswer[' + value + ']"]').attr('data-val-copy');
                                if (answer == 'Yes') {
                                    motor_cluster_pass_val_count += 1;
                                }
                            });
                            $('input[name="motor_cluster_' + i + '"]').val(motor_cluster_pass_val_count);
                            $('#motor_cluster_' + i + '').html(motor_cluster_pass_val_count);
                        }
                        var dasii_age = parseFloat($('input[name="dasii_age"]').val());
                        var motor_cluster = $('input[name="motor_cluster"]').val();
                        if (motor_cluster != 'null') {
                            motor_cluster = JSON.parse(motor_cluster);
                            var month_array = 0;
                            var motor_month_in_range = false;
                            $.each(motor_cluster, function(item, value) {
                                var range = value[0];
                                var month_starting_value = range.month_starting_value;
                                var month_ending_value = range.month_ending_value;
                                if (month_starting_value <= dasii_age && dasii_age <= month_ending_value) {
                                    month_array = range.month;
                                    motor_month_in_range = true;
                                    return false;
                                }
                            });
                            if (motor_month_in_range) {
                                if (motor_cluster[month_array][0].month == 1) {
                                    var cluster_range = motor_cluster[month_array][0].month + ' Month (' + motor_cluster[month_array][0].month_starting_value + ' - ' + motor_cluster[month_array][0].month_ending_value + ')';
                                } else {
                                    var cluster_range = motor_cluster[month_array][0].month + ' Months (' + motor_cluster[month_array][0].month_starting_value + ' - ' + motor_cluster[month_array][0].month_ending_value + ')';
                                }
                                $('#cluster_range').attr('title', 'Cluster Range: ' + cluster_range);
                                $('input[name="cluster_range"]').val(cluster_range);
                                $('.motor-remarks-status').removeClass('remarks-delay').removeClass('remarks-more-delay');
                                var motor_pr_stop_1 = false;
                                var motor_pr_stop_2 = false;
                                var motor_pr_stop_3 = false;
                                var motor_pr_stop_4 = false;
                                var motor_pr_stop_5 = false;
                                var motor_temp_value_1 = false;
                                var motor_temp_value_2 = false;
                                var motor_temp_value_3 = false;
                                var motor_temp_value_4 = false;
                                var motor_temp_value_5 = false;
                                var motor_temp_percentile_1 = '';
                                var motor_temp_percentile_2 = '';
                                var motor_temp_percentile_3 = '';
                                var motor_temp_percentile_4 = '';
                                var motor_temp_percentile_5 = '';
                                var motor_loop_1 = 0;
                                var motor_loop_2 = 0;
                                var motor_loop_3 = 0;
                                var motor_loop_4 = 0;
                                var motor_loop_5 = 0;

                                $.each(motor_cluster[month_array], function(item, value) {
                                    var activity_type_1 = value.activity_type_1;
                                    var percentile = value.percentile;
                                    var motor_cluster_1 = $('input[name="motor_cluster_1"]').val();
                                    motor_cluster_1 = parseInt(motor_cluster_1);
                                    if (motor_loop_1 == 0) {
                                        if (!motor_pr_stop_1) {
                                            if (activity_type_1 == motor_cluster_1) {
                                                $('input[name="motor_cluster_pr_1"]').val(percentile + '<sup>th</sup>');
                                                $('#motor_cluster_pr_1 span').html(percentile + '<sup>th</sup>');
                                                motor_pr_stop_1 = true;
                                            } else if (activity_type_1 < motor_cluster_1 && item == 0) {
                                                $('input[name="motor_cluster_pr_1"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#motor_cluster_pr_1 span').html('> ' + percentile + '<sup>th</sup>');
                                                motor_pr_stop_1 = true;
                                            } else {
                                                var next_value = motor_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_1 = next_value.activity_type_1;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_1 < motor_cluster_1 && motor_cluster_1 < activity_type_1) {
                                                        $('input[name="motor_cluster_pr_1"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#motor_cluster_pr_1 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        motor_temp_value_1 = true;
                                                        motor_temp_percentile_1 = next_percentile;
                                                    }
                                                } else {
                                                    if (motor_temp_value_1) {
                                                        motor_pr_stop_1 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="motor_cluster_remarks_1"]').val('Normal');
                                            $('#motor_cluster_remarks_1 span').html('Normal');
                                        }
                                        if (motor_pr_stop_1 && motor_loop_1 == 0) {
                                            percentile = motor_temp_percentile_1 != '' ? parseInt(motor_temp_percentile_1) : percentile;
                                            if (percentile < 50) {
                                                $('#motor_cluster_remarks_1 span').parents('td').addClass('remarks-delay');
                                            }
                                            motor_loop_1 = 1;
                                            motor_temp_percentile_1 = '';
                                        }
                                    }
                                    var activity_type_2 = value.activity_type_2;
                                    var percentile = value.percentile;
                                    var motor_cluster_2 = $('input[name="motor_cluster_2"]').val();
                                    motor_cluster_2 = parseInt(motor_cluster_2);
                                    if (motor_loop_2 == 0) {
                                        if (!motor_pr_stop_2) {
                                            if (activity_type_2 == motor_cluster_2) {
                                                $('input[name="motor_cluster_pr_2"]').val(percentile + '<sup>th</sup>');
                                                $('#motor_cluster_pr_2 span').html(percentile + '<sup>th</sup>');
                                                motor_pr_stop_2 = true;
                                            } else if (activity_type_2 < motor_cluster_2 && item == 0) {
                                                $('input[name="motor_cluster_pr_2"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#motor_cluster_pr_2 span').html('> ' + percentile + '<sup>th</sup>');
                                                motor_pr_stop_2 = true;
                                            } else {
                                                var next_value = motor_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_2 = next_value.activity_type_2;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_2 < motor_cluster_2 && motor_cluster_2 < activity_type_2) {
                                                        $('input[name="motor_cluster_pr_2"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#motor_cluster_pr_2 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        motor_temp_value_2 = true;
                                                        motor_temp_percentile_2 = next_percentile;
                                                    }
                                                } else {
                                                    if (motor_temp_value_2) {
                                                        motor_pr_stop_2 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="motor_cluster_remarks_2"]').val('Normal');
                                            $('#motor_cluster_remarks_2 span').html('Normal');
                                        }
                                        if (motor_pr_stop_2 && motor_loop_2 == 0) {
                                            percentile = motor_temp_percentile_2 != '' ? parseInt(motor_temp_percentile_2) : percentile;
                                            if (percentile < 50) {
                                                $('#motor_cluster_remarks_2 span').parents('td').addClass('remarks-delay');
                                            }
                                            motor_loop_2 = 1;
                                            motor_temp_percentile_2 = '';
                                        }
                                    }
                                    var activity_type_3 = value.activity_type_3;
                                    var percentile = value.percentile;
                                    var motor_cluster_3 = $('input[name="motor_cluster_3"]').val();
                                    motor_cluster_3 = parseInt(motor_cluster_3);
                                    if (motor_loop_3 == 0) {
                                        if (!motor_pr_stop_3) {
                                            if (activity_type_3 == motor_cluster_3) {
                                                $('input[name="motor_cluster_pr_3"]').val(percentile + '<sup>th</sup>');
                                                $('#motor_cluster_pr_3 span').html(percentile + '<sup>th</sup>');
                                                motor_pr_stop_3 = true;
                                            } else if (activity_type_3 < motor_cluster_3 && item == 0) {
                                                $('input[name="motor_cluster_pr_3"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#motor_cluster_pr_3 span').html('> ' + percentile + '<sup>th</sup>');
                                                motor_pr_stop_3 = true;
                                            } else {
                                                var next_value = motor_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_3 = next_value.activity_type_3;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_3 < motor_cluster_3 && motor_cluster_3 < activity_type_3) {
                                                        $('input[name="motor_cluster_pr_3"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#motor_cluster_pr_3 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        motor_temp_value_3 = true;
                                                        motor_temp_percentile_3 = next_percentile;
                                                    }
                                                } else {
                                                    if (motor_temp_value_3) {
                                                        motor_pr_stop_3 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="motor_cluster_remarks_3"]').val('Normal');
                                            $('#motor_cluster_remarks_3 span').html('Normal');
                                        }
                                        if (motor_pr_stop_3 && motor_loop_3 == 0) {
                                            percentile = motor_temp_percentile_3 != '' ? parseInt(motor_temp_percentile_3) : percentile;
                                            if (percentile < 50) {
                                                $('#motor_cluster_remarks_3 span').parents('td').addClass('remarks-delay');
                                            }
                                            motor_loop_3 = 1;
                                            motor_temp_percentile_3 = '';
                                        }
                                    }
                                    var activity_type_4 = value.activity_type_4;
                                    var percentile = value.percentile;
                                    var motor_cluster_4 = $('input[name="motor_cluster_4"]').val();
                                    motor_cluster_4 = parseInt(motor_cluster_4);
                                    if (motor_loop_4 == 0) {
                                        if (!motor_pr_stop_4) {
                                            if (activity_type_4 == motor_cluster_4) {
                                                $('input[name="motor_cluster_pr_4"]').val(percentile + '<sup>th</sup>');
                                                $('#motor_cluster_pr_4 span').html(percentile + '<sup>th</sup>');
                                                motor_pr_stop_4 = true;
                                            } else if (activity_type_4 < motor_cluster_4 && item == 0) {
                                                $('input[name="motor_cluster_pr_4"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#motor_cluster_pr_4 span').html('> ' + percentile + '<sup>th</sup>');
                                                motor_pr_stop_4 = true;
                                            } else {
                                                var next_value = motor_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_4 = next_value.activity_type_4;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_4 < motor_cluster_4 && motor_cluster_4 < activity_type_4) {
                                                        $('input[name="motor_cluster_pr_4"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#motor_cluster_pr_4 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        motor_temp_value_4 = true;
                                                        motor_temp_percentile_4 = next_percentile;
                                                    }
                                                } else {
                                                    if (motor_temp_value_4) {
                                                        motor_pr_stop_4 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="motor_cluster_remarks_4"]').val('Normal');
                                            $('#motor_cluster_remarks_4 span').html('Normal');
                                        }
                                        if (motor_pr_stop_4 && motor_loop_4 == 0) {
                                            percentile = motor_temp_percentile_4 != '' ? parseInt(motor_temp_percentile_4) : percentile;
                                            if (percentile < 50) {
                                                $('#motor_cluster_remarks_4 span').parents('td').addClass('remarks-delay');
                                            }
                                            motor_loop_4 = 1;
                                            motor_temp_percentile_4 = '';
                                        }
                                    }
                                    var activity_type_5 = value.activity_type_5;
                                    var percentile = value.percentile;
                                    var motor_cluster_5 = $('input[name="motor_cluster_5"]').val();
                                    motor_cluster_5 = parseInt(motor_cluster_5);
                                    if (motor_loop_5 == 0) {
                                        if (!motor_pr_stop_5) {
                                            if (activity_type_5 == motor_cluster_5) {
                                                $('input[name="motor_cluster_pr_5"]').val(percentile + '<sup>th</sup>');
                                                $('#motor_cluster_pr_5 span').html(percentile + '<sup>th</sup>');
                                                motor_pr_stop_5 = true;
                                            } else if (activity_type_5 < motor_cluster_5 && item == 0) {
                                                $('input[name="motor_cluster_pr_5"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#motor_cluster_pr_5 span').html('> ' + percentile + '<sup>th</sup>');
                                                motor_pr_stop_5 = true;
                                            } else {
                                                var next_value = motor_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_5 = next_value.activity_type_5;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_5 < motor_cluster_5 && motor_cluster_5 < activity_type_5) {
                                                        $('input[name="motor_cluster_pr_5"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#motor_cluster_pr_5 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        motor_temp_value_5 = true;
                                                        motor_temp_percentile_5 = next_percentile;
                                                    }
                                                } else {
                                                    if (motor_temp_value_5) {
                                                        motor_pr_stop_5 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="motor_cluster_remarks_5"]').val('Normal');
                                            $('#motor_cluster_remarks_5 span').html('Normal');
                                        }
                                        if (motor_pr_stop_5 && motor_loop_5 == 0) {
                                            percentile = motor_temp_percentile_5 != '' ? parseInt(motor_temp_percentile_5) : percentile;
                                            if (percentile < 50) {
                                                $('#motor_cluster_remarks_5 span').parents('td').addClass('remarks-delay');
                                            }
                                            motor_loop_5 = 1;
                                            motor_temp_percentile_5 = '';
                                        }
                                    }
                                });
                                if (!motor_pr_stop_1) {
                                    $('input[name="motor_cluster_pr_1"]').val('< 10<sup>th</sup>');
                                    $('#motor_cluster_pr_1 span').html('< 10<sup>th</sup>');
                                    $('input[name="motor_cluster_remarks_1"]').val('Delay');
                                    $('#motor_cluster_remarks_1 span').html('Delay');
                                    $('#motor_cluster_remarks_1').addClass('remarks-more-delay');
                                }
                                if (!motor_pr_stop_2) {
                                    $('input[name="motor_cluster_pr_2"]').val('< 10<sup>th</sup>');
                                    $('#motor_cluster_pr_2 span').html('< 10<sup>th</sup>');
                                    $('input[name="motor_cluster_remarks_2"]').val('Delay');
                                    $('#motor_cluster_remarks_2 span').html('Delay');
                                    $('#motor_cluster_remarks_2').addClass('remarks-more-delay');
                                }
                                if (!motor_pr_stop_3) {
                                    $('input[name="motor_cluster_pr_3"]').val('< 10<sup>th</sup>');
                                    $('#motor_cluster_pr_3 span').html('< 10<sup>th</sup>');
                                    $('input[name="motor_cluster_remarks_3"]').val('Delay');
                                    $('#motor_cluster_remarks_3 span').html('Delay');
                                    $('#motor_cluster_remarks_3').addClass('remarks-more-delay');
                                }
                                if (!motor_pr_stop_4) {
                                    $('input[name="motor_cluster_pr_4"]').val('< 10<sup>th</sup>');
                                    $('#motor_cluster_pr_4 span').html('< 10<sup>th</sup>');
                                    $('input[name="motor_cluster_remarks_4"]').val('Delay');
                                    $('#motor_cluster_remarks_4 span').html('Delay');
                                    $('#motor_cluster_remarks_4').addClass('remarks-more-delay');
                                }
                                if (!motor_pr_stop_5) {
                                    $('input[name="motor_cluster_pr_5"]').val('< 10<sup>th</sup>');
                                    $('#motor_cluster_pr_5 span').html('< 10<sup>th</sup>');
                                    $('input[name="motor_cluster_remarks_5"]').val('Delay');
                                    $('#motor_cluster_remarks_5 span').html('Delay');
                                    $('#motor_cluster_remarks_5').addClass('remarks-more-delay');
                                }
                            }
                        }
                    } else {
                        for (var i = 1; i <= 10; i++) {
                            var mental_cluster = $('input[name="mental_cluster_question_' + i + '"]').val();
                            mental_cluster = JSON.parse(mental_cluster);
                            var mental_cluster_pass_val_count = 0;
                            $.each(mental_cluster, function(key, value) {
                                var answer = $('input[name="mentalanswer[' + value + ']"]').attr('data-val-copy');
                                if (answer == 'Yes') {
                                    mental_cluster_pass_val_count += 1;
                                }
                            });
                            $('input[name="mental_cluster_' + i + '"]').val(mental_cluster_pass_val_count);
                            $('#mental_cluster_' + i + '').html(mental_cluster_pass_val_count);
                        }
                        var dasii_age = parseFloat($('input[name="dasii_age"]').val());
                        var mental_cluster = $('input[name="mental_cluster"]').val();
                        if (mental_cluster != 'null') {
                            mental_cluster = JSON.parse(mental_cluster);
                            var month_array = 0;
                            var mental_month_in_range = false;
                            $.each(mental_cluster, function(item, value) {
                                var range = value[0];
                                var month_starting_value = range.month_starting_value;
                                var month_ending_value = range.month_ending_value;
                                if (month_starting_value <= dasii_age && dasii_age <= month_ending_value) {
                                    month_array = range.month;
                                    mental_month_in_range = true;
                                    return false;
                                }
                            });
                            if (mental_month_in_range) {
                                if (mental_cluster[month_array][0].month == 1) {
                                    var cluster_range = mental_cluster[month_array][0].month + ' Month (' + mental_cluster[month_array][0].month_starting_value + ' - ' + mental_cluster[month_array][0].month_ending_value + ')';
                                } else {
                                    var cluster_range = mental_cluster[month_array][0].month + ' Months (' + mental_cluster[month_array][0].month_starting_value + ' - ' + mental_cluster[month_array][0].month_ending_value + ')';
                                }
                                $('#cluster_range').attr('title', 'Cluster Range: ' + cluster_range);
                                $('input[name="cluster_range"]').val(cluster_range);
                                $('.mental-remarks-status').removeClass('remarks-delay').removeClass('remarks-more-delay');
                                var mental_pr_stop_1 = false;
                                var mental_pr_stop_2 = false;
                                var mental_pr_stop_3 = false;
                                var mental_pr_stop_4 = false;
                                var mental_pr_stop_5 = false;
                                var mental_pr_stop_6 = false;
                                var mental_pr_stop_7 = false;
                                var mental_pr_stop_8 = false;
                                var mental_pr_stop_9 = false;
                                var mental_pr_stop_10 = false;
                                var temp_value_1 = false;
                                var temp_value_2 = false;
                                var temp_value_3 = false;
                                var temp_value_4 = false;
                                var temp_value_5 = false;
                                var temp_value_6 = false;
                                var temp_value_7 = false;
                                var temp_value_8 = false;
                                var temp_value_9 = false;
                                var temp_value_10 = false;
                                var mental_temp_percentile_1 = '';
                                var mental_temp_percentile_2 = '';
                                var mental_temp_percentile_3 = '';
                                var mental_temp_percentile_4 = '';
                                var mental_temp_percentile_5 = '';
                                var mental_temp_percentile_6 = '';
                                var mental_temp_percentile_7 = '';
                                var mental_temp_percentile_8 = '';
                                var mental_temp_percentile_9 = '';
                                var mental_temp_percentile_10 = '';
                                var mental_loop_1 = 0;
                                var mental_loop_2 = 0;
                                var mental_loop_3 = 0;
                                var mental_loop_4 = 0;
                                var mental_loop_5 = 0;
                                var mental_loop_6 = 0;
                                var mental_loop_7 = 0;
                                var mental_loop_8 = 0;
                                var mental_loop_9 = 0;
                                var mental_loop_10 = 0;
                                $.each(mental_cluster[month_array], function(item, value) {
                                    var activity_type_1 = value.activity_type_1;
                                    var percentile = value.percentile;
                                    var mental_cluster_1 = $('input[name="mental_cluster_1"]').val();
                                    mental_cluster_1 = parseInt(mental_cluster_1);
                                    if (mental_loop_1 == 0) {
                                        if (!mental_pr_stop_1) {
                                            if (activity_type_1 == mental_cluster_1) {
                                                $('input[name="mental_cluster_pr_1"]').val(percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_1 span').html(percentile + '<sup>th</sup>');
                                                mental_pr_stop_1 = true;
                                            } else if (activity_type_1 < mental_cluster_1 && item == 0) {
                                                $('input[name="mental_cluster_pr_1"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_1 span').html('> ' + percentile + '<sup>th</sup>');
                                                mental_pr_stop_1 = true;
                                            } else {
                                                var next_value = mental_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_1 = next_value.activity_type_1;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_1 < mental_cluster_1 && mental_cluster_1 < activity_type_1) {
                                                        $('input[name="mental_cluster_pr_1"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#mental_cluster_pr_1 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        temp_value_1 = true;
                                                        mental_temp_percentile_1 = next_percentile;
                                                    }
                                                } else {
                                                    if (temp_value_1) {
                                                        mental_pr_stop_1 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="mental_cluster_remarks_1"]').val('Normal');
                                            $('#mental_cluster_remarks_1 span').html('Normal');
                                        }
                                        if (mental_pr_stop_1 && mental_loop_1 == 0) {
                                            percentile = mental_temp_percentile_1 != '' ? parseInt(mental_temp_percentile_1) : percentile;
                                            if (percentile < 50) {
                                                $('#mental_cluster_remarks_1 span').parents('td').addClass('remarks-delay');
                                            }
                                            mental_loop_1 = 1;
                                            mental_temp_percentile_1 = '';
                                        }
                                    }
                                    var activity_type_2 = value.activity_type_2;
                                    var percentile = value.percentile;
                                    var mental_cluster_2 = $('input[name="mental_cluster_2"]').val();
                                    mental_cluster_2 = parseInt(mental_cluster_2);
                                    if (mental_loop_2 == 0) {
                                        if (!mental_pr_stop_2) {
                                            if (activity_type_2 == mental_cluster_2) {
                                                $('input[name="mental_cluster_pr_2"]').val(percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_2 span').html(percentile + '<sup>th</sup>');
                                                mental_pr_stop_2 = true;
                                            } else if (activity_type_2 < mental_cluster_2 && item == 0) {
                                                $('input[name="mental_cluster_pr_2"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_2 span').html('> ' + percentile + '<sup>th</sup>');
                                                mental_pr_stop_2 = true;
                                            } else {
                                                var next_value = mental_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_2 = next_value.activity_type_2;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_2 < mental_cluster_2 && mental_cluster_2 < activity_type_2) {
                                                        $('input[name="mental_cluster_pr_2"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#mental_cluster_pr_2 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        temp_value_2 = true;
                                                        mental_temp_percentile_2 = next_percentile;
                                                    }
                                                } else {
                                                    if (temp_value_2) {
                                                        mental_pr_stop_2 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="mental_cluster_remarks_2"]').val('Normal');
                                            $('#mental_cluster_remarks_2 span').html('Normal');
                                        }
                                        if (mental_pr_stop_2 && mental_loop_2 == 0) {
                                            percentile = mental_temp_percentile_2 != '' ? parseInt(mental_temp_percentile_2) : percentile;
                                            if (percentile < 50) {
                                                $('#mental_cluster_remarks_2 span').parents('td').addClass('remarks-delay');
                                            }
                                            mental_loop_2 = 1;
                                            mental_temp_percentile_2 = '';
                                        }
                                    }
                                    var activity_type_3 = value.activity_type_3;
                                    var percentile = value.percentile;
                                    var mental_cluster_3 = parseInt($('input[name="mental_cluster_3"]').val());
                                    if (mental_loop_3 == 0) {
                                        if (!mental_pr_stop_3) {
                                            if (activity_type_3 == mental_cluster_3) {
                                                $('input[name="mental_cluster_pr_3"]').val(percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_3 span').html(percentile + '<sup>th</sup>');
                                                mental_pr_stop_3 = true;
                                            } else if (activity_type_3 < mental_cluster_3 && item == 0) {
                                                $('input[name="mental_cluster_pr_3"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_3 span').html('> ' + percentile + '<sup>th</sup>');
                                                mental_pr_stop_3 = true;
                                            } else {
                                                var next_value = mental_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_3 = next_value.activity_type_3;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_3 < mental_cluster_3 && mental_cluster_3 < activity_type_3) {
                                                        $('input[name="mental_cluster_pr_3"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#mental_cluster_pr_3 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        temp_value_3 = true;
                                                        mental_temp_percentile_3 = next_percentile;
                                                    }
                                                } else {
                                                    if (temp_value_3) {
                                                        mental_pr_stop_3 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="mental_cluster_remarks_3"]').val('Normal');
                                            $('#mental_cluster_remarks_3 span').html('Normal');
                                        }
                                        if (mental_pr_stop_3 && mental_loop_3 == 0) {
                                            percentile = mental_temp_percentile_3 != '' ? parseInt(mental_temp_percentile_3) : percentile;
                                            if (percentile < 50) {
                                                $('#mental_cluster_remarks_3 span').parents('td').addClass('remarks-delay');
                                            }
                                            mental_loop_3 = 1;
                                            mental_temp_percentile_3 = '';
                                        }
                                    }
                                    var activity_type_4 = value.activity_type_4;
                                    var percentile = value.percentile;
                                    var mental_cluster_4 = $('input[name="mental_cluster_4"]').val();
                                    mental_cluster_4 = parseInt(mental_cluster_4);
                                    if (mental_loop_4 == 0) {
                                        if (!mental_pr_stop_4) {
                                            if (activity_type_4 == mental_cluster_4) {
                                                $('input[name="mental_cluster_pr_4"]').val(percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_4 span').html(percentile + '<sup>th</sup>');
                                                mental_pr_stop_4 = true;
                                            } else if (activity_type_4 < mental_cluster_4 && item == 0) {
                                                $('input[name="mental_cluster_pr_4"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_4 span').html('> ' + percentile + '<sup>th</sup>');
                                                mental_pr_stop_4 = true;
                                            } else {
                                                var next_value = mental_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_4 = next_value.activity_type_4;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_4 < mental_cluster_4 && mental_cluster_4 < activity_type_4) {
                                                        $('input[name="mental_cluster_pr_4"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#mental_cluster_pr_4 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        temp_value_4 = true;
                                                        mental_temp_percentile_4 = next_percentile;
                                                    }
                                                } else {
                                                    if (temp_value_4) {
                                                        mental_pr_stop_4 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="mental_cluster_remarks_4"]').val('Normal');
                                            $('#mental_cluster_remarks_4 span').html('Normal');
                                        }
                                        if (mental_pr_stop_4 && mental_loop_4 == 0) {
                                            percentile = mental_temp_percentile_4 != '' ? parseInt(mental_temp_percentile_4) : percentile;
                                            if (percentile < 50) {
                                                $('#mental_cluster_remarks_4 span').parents('td').addClass('remarks-delay');
                                            }
                                            mental_loop_4 = 1;
                                            mental_temp_percentile_4 = '';
                                        }
                                    }
                                    var activity_type_5 = value.activity_type_5;
                                    var percentile = value.percentile;
                                    var mental_cluster_5 = $('input[name="mental_cluster_5"]').val();
                                    mental_cluster_5 = parseInt(mental_cluster_5);
                                    if (mental_loop_5 == 0) {
                                        if (!mental_pr_stop_5) {
                                            if (activity_type_5 == mental_cluster_5) {
                                                $('input[name="mental_cluster_pr_5"]').val(percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_5 span').html(percentile + '<sup>th</sup>');
                                                mental_pr_stop_5 = true;
                                            } else if (activity_type_5 < mental_cluster_5 && item == 0) {
                                                $('input[name="mental_cluster_pr_5"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_5 span').html('> ' + percentile + '<sup>th</sup>');
                                                mental_pr_stop_5 = true;
                                            } else {
                                                var next_value = mental_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_5 = next_value.activity_type_5;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_5 < mental_cluster_5 && mental_cluster_5 < activity_type_5) {
                                                        $('input[name="mental_cluster_pr_5"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#mental_cluster_pr_5 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        temp_value_5 = true;
                                                        mental_temp_percentile_5 = next_percentile;
                                                    }
                                                } else {
                                                    if (temp_value_5) {
                                                        mental_pr_stop_5 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="mental_cluster_remarks_5"]').val('Normal');
                                            $('#mental_cluster_remarks_5 span').html('Normal');
                                        }
                                        if (mental_pr_stop_5 && mental_loop_5 == 0) {
                                            percentile = mental_temp_percentile_5 != '' ? parseInt(mental_temp_percentile_5) : percentile;
                                            if (percentile < 50) {
                                                $('#mental_cluster_remarks_5 span').parents('td').addClass('remarks-delay');
                                            }
                                            mental_loop_5 = 1;
                                            mental_temp_percentile_5 = '';
                                        }
                                    }
                                    var activity_type_6 = value.activity_type_6;
                                    var percentile = value.percentile;
                                    var mental_cluster_6 = $('input[name="mental_cluster_6"]').val();
                                    mental_cluster_6 = parseInt(mental_cluster_6);
                                    if (mental_loop_6 == 0) {
                                        if (!mental_pr_stop_6) {
                                            if (activity_type_6 == mental_cluster_6) {
                                                $('input[name="mental_cluster_pr_6"]').val(percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_6 span').html(percentile + '<sup>th</sup>');
                                                mental_pr_stop_6 = true;
                                            } else if (activity_type_6 < mental_cluster_6 && item == 0) {
                                                $('input[name="mental_cluster_pr_6"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_6 span').html('> ' + percentile + '<sup>th</sup>');
                                                mental_pr_stop_6 = true;
                                            } else {
                                                var next_value = mental_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_6 = next_value.activity_type_6;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_6 < mental_cluster_6 && mental_cluster_6 < activity_type_6) {
                                                        $('input[name="mental_cluster_pr_6"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#mental_cluster_pr_6 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        temp_value_6 = true;
                                                        mental_temp_percentile_6 = next_percentile;
                                                    }
                                                } else {
                                                    if (temp_value_6) {
                                                        mental_pr_stop_6 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="mental_cluster_remarks_6"]').val('Normal');
                                            $('#mental_cluster_remarks_6 span').html('Normal');
                                        }
                                        if (mental_pr_stop_6 && mental_loop_6 == 0) {
                                            percentile = mental_temp_percentile_6 != '' ? parseInt(mental_temp_percentile_6) : percentile;
                                            if (percentile < 50) {
                                                $('#mental_cluster_remarks_6 span').parents('td').addClass('remarks-delay');
                                            }
                                            mental_loop_6 = 1;
                                            mental_temp_percentile_6 = '';
                                        }
                                    }
                                    var activity_type_7 = value.activity_type_7;
                                    var percentile = value.percentile;
                                    var mental_cluster_7 = $('input[name="mental_cluster_7"]').val();
                                    mental_cluster_7 = parseInt(mental_cluster_7);
                                    if (mental_loop_7 == 0) {
                                        if (!mental_pr_stop_7) {
                                            if (activity_type_7 == mental_cluster_7) {
                                                $('input[name="mental_cluster_pr_7"]').val(percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_7 span').html(percentile + '<sup>th</sup>');
                                                mental_pr_stop_7 = true;
                                            } else if (activity_type_7 < mental_cluster_7 && item == 0) {
                                                $('input[name="mental_cluster_pr_7"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_7 span').html('> ' + percentile + '<sup>th</sup>');
                                                mental_pr_stop_7 = true;
                                            } else {
                                                var next_value = mental_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_7 = next_value.activity_type_7;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_7 < mental_cluster_7 && mental_cluster_7 < activity_type_7) {
                                                        $('input[name="mental_cluster_pr_7"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#mental_cluster_pr_7 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        temp_value_7 = true;
                                                        mental_temp_percentile_7 = next_percentile;
                                                    }
                                                } else {
                                                    if (temp_value_7) {
                                                        mental_pr_stop_7 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="mental_cluster_remarks_7"]').val('Normal');
                                            $('#mental_cluster_remarks_7 span').html('Normal');
                                        }
                                        if (mental_pr_stop_7 && mental_loop_7 == 0) {
                                            percentile = mental_temp_percentile_7 != '' ? parseInt(mental_temp_percentile_7) : percentile;
                                            if (percentile < 50) {
                                                $('#mental_cluster_remarks_7 span').parents('td').addClass('remarks-delay');
                                            }
                                            mental_loop_7 = 1;
                                            mental_temp_percentile_7 = '';
                                        }
                                    }
                                    var activity_type_8 = value.activity_type_8;
                                    var percentile = value.percentile;
                                    var mental_cluster_8 = $('input[name="mental_cluster_8"]').val();
                                    mental_cluster_8 = parseInt(mental_cluster_8);
                                    if (mental_loop_8 == 0) {
                                        if (!mental_pr_stop_8) {
                                            if (activity_type_8 == mental_cluster_8) {
                                                $('input[name="mental_cluster_pr_8"]').val(percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_8 span').html(percentile + '<sup>th</sup>');
                                                mental_pr_stop_8 = true;
                                            } else if (activity_type_8 < mental_cluster_8 && item == 0) {
                                                $('input[name="mental_cluster_pr_8"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_8 span').html('> ' + percentile + '<sup>th</sup>');
                                                mental_pr_stop_8 = true;
                                            } else {
                                                var next_value = mental_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_8 = next_value.activity_type_8;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_8 < mental_cluster_8 && mental_cluster_8 < activity_type_8) {
                                                        $('input[name="mental_cluster_pr_8"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#mental_cluster_pr_8 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        temp_value_8 = true;
                                                        mental_temp_percentile_8 = next_percentile;
                                                    }
                                                } else {
                                                    if (temp_value_8) {
                                                        mental_pr_stop_8 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="mental_cluster_remarks_8"]').val('Normal');
                                            $('#mental_cluster_remarks_8 span').html('Normal');
                                        }
                                        if (mental_pr_stop_8 && mental_loop_8 == 0) {
                                            percentile = mental_temp_percentile_8 != '' ? parseInt(mental_temp_percentile_8) : percentile;
                                            if (percentile < 50) {
                                                $('#mental_cluster_remarks_8 span').parents('td').addClass('remarks-delay');
                                            }
                                            mental_loop_8 = 1;
                                            mental_temp_percentile_8 = '';
                                        }
                                    }
                                    var activity_type_9 = value.activity_type_9;
                                    var percentile = value.percentile;
                                    var mental_cluster_9 = $('input[name="mental_cluster_9"]').val();
                                    mental_cluster_9 = parseInt(mental_cluster_9);
                                    if (mental_loop_9 == 0) {
                                        if (!mental_pr_stop_9) {
                                            if (activity_type_9 == mental_cluster_9) {
                                                $('input[name="mental_cluster_pr_9"]').val(percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_9 span').html(percentile + '<sup>th</sup>');
                                                mental_pr_stop_9 = true;
                                            } else if (activity_type_9 < mental_cluster_9 && item == 0) {
                                                $('input[name="mental_cluster_pr_9"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_9 span').html('> ' + percentile + '<sup>th</sup>');
                                                mental_pr_stop_9 = true;
                                            } else {
                                                var next_value = mental_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_9 = next_value.activity_type_9;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_9 < mental_cluster_9 && mental_cluster_9 < activity_type_9) {
                                                        $('input[name="mental_cluster_pr_9"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#mental_cluster_pr_9 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        temp_value_9 = true;
                                                        mental_temp_percentile_9 = next_percentile;
                                                    }
                                                } else {
                                                    if (temp_value_9) {
                                                        mental_pr_stop_9 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="mental_cluster_remarks_9"]').val('Normal');
                                            $('#mental_cluster_remarks_9 span').html('Normal');
                                        }
                                        if (mental_pr_stop_9 && mental_loop_9 == 0) {
                                            percentile = mental_temp_percentile_9 != '' ? parseInt(mental_temp_percentile_9) : percentile;
                                            if (percentile < 50) {
                                                $('#mental_cluster_remarks_9 span').parents('td').addClass('remarks-delay');
                                            }
                                            mental_loop_9 = 1;
                                            mental_temp_percentile_9 = '';
                                        }
                                    }
                                    var activity_type_10 = value.activity_type_10;
                                    var percentile = value.percentile;
                                    var mental_cluster_10 = $('input[name="mental_cluster_10"]').val();
                                    mental_cluster_10 = parseInt(mental_cluster_10);
                                    if (mental_loop_10 == 0) {
                                        if (!mental_pr_stop_10) {
                                            if (activity_type_10 == mental_cluster_10) {
                                                $('input[name="mental_cluster_pr_10"]').val(percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_10 span').html(percentile + '<sup>th</sup>');
                                                mental_pr_stop_10 = true;
                                            } else if (activity_type_10 < mental_cluster_10 && item == 0) {
                                                $('input[name="mental_cluster_pr_10"]').val('> ' + percentile + '<sup>th</sup>');
                                                $('#mental_cluster_pr_10 span').html('> ' + percentile + '<sup>th</sup>');
                                                mental_pr_stop_10 = true;
                                            } else {
                                                var next_value = mental_cluster[month_array][item + 1];
                                                if (typeof next_value !== 'undefined') {
                                                    var next_activity_type_10 = next_value.activity_type_10;
                                                    var next_percentile = next_value.percentile;
                                                    if (next_activity_type_10 < mental_cluster_10 && mental_cluster_10 < activity_type_10) {
                                                        $('input[name="mental_cluster_pr_10"]').val(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        $('#mental_cluster_pr_10 span').html(next_percentile + '<sup>th</sup> - ' + percentile + '<sup>th</sup>');
                                                        temp_value_10 = true;
                                                        mental_temp_percentile_10 = next_percentile;
                                                    }
                                                } else {
                                                    if (temp_value_10) {
                                                        mental_pr_stop_10 = true;
                                                    }
                                                }
                                            }
                                            $('input[name="mental_cluster_remarks_10"]').val('Normal');
                                            $('#mental_cluster_remarks_10 span').html('Normal');
                                        }
                                        if (mental_pr_stop_10 && mental_loop_10 == 0) {
                                            percentile = mental_temp_percentile_10 != '' ? parseInt(mental_temp_percentile_10) : percentile;
                                            if (percentile < 50) {
                                                $('#mental_cluster_remarks_10 span').parents('td').addClass('remarks-delay');
                                            }
                                            mental_loop_10 = 1;
                                            mental_temp_percentile_10 = '';
                                        }
                                    }
                                });
                                if (!mental_pr_stop_1) {
                                    $('input[name="mental_cluster_pr_1"]').val('< 10<sup>th</sup>');
                                    $('#mental_cluster_pr_1 span').html('< 10<sup>th</sup>');
                                    $('input[name="mental_cluster_remarks_1"]').val('Delay');
                                    $('#mental_cluster_remarks_1 span').html('Delay');
                                    $('#mental_cluster_remarks_1').addClass('remarks-more-delay');
                                }
                                if (!mental_pr_stop_2) {
                                    $('input[name="mental_cluster_pr_2"]').val('< 10<sup>th</sup>');
                                    $('#mental_cluster_pr_2 span').html('< 10<sup>th</sup>');
                                    $('input[name="mental_cluster_remarks_2"]').val('Delay');
                                    $('#mental_cluster_remarks_2 span').html('Delay');
                                    $('#mental_cluster_remarks_2').addClass('remarks-more-delay');
                                }
                                if (!mental_pr_stop_3) {
                                    $('input[name="mental_cluster_pr_3"]').val('< 10<sup>th</sup>');
                                    $('#mental_cluster_pr_3 span').html('< 10<sup>th</sup>');
                                    $('input[name="mental_cluster_remarks_3"]').val('Delay');
                                    $('#mental_cluster_remarks_3 span').html('Delay');
                                    $('#mental_cluster_remarks_3').addClass('remarks-more-delay');
                                }
                                if (!mental_pr_stop_4) {
                                    $('input[name="mental_cluster_pr_4"]').val('< 10<sup>th</sup>');
                                    $('#mental_cluster_pr_4 span').html('< 10<sup>th</sup>');
                                    $('input[name="mental_cluster_remarks_4"]').val('Delay');
                                    $('#mental_cluster_remarks_4 span').html('Delay');
                                    $('#mental_cluster_remarks_4').addClass('remarks-more-delay');
                                }
                                if (!mental_pr_stop_5) {
                                    $('input[name="mental_cluster_pr_5"]').val('< 10<sup>th</sup>');
                                    $('#mental_cluster_pr_5 span').html('< 10<sup>th</sup>');
                                    $('input[name="mental_cluster_remarks_5"]').val('Delay');
                                    $('#mental_cluster_remarks_5 span').html('Delay');
                                    $('#mental_cluster_remarks_5').addClass('remarks-more-delay');
                                }
                                if (!mental_pr_stop_6) {
                                    $('input[name="mental_cluster_pr_6"]').val('< 10<sup>th</sup>');
                                    $('#mental_cluster_pr_6 span').html('< 10<sup>th</sup>');
                                    $('input[name="mental_cluster_remarks_6"]').val('Delay');
                                    $('#mental_cluster_remarks_6 span').html('Delay');
                                    $('#mental_cluster_remarks_6').addClass('remarks-more-delay');
                                }
                                if (!mental_pr_stop_7) {
                                    $('input[name="mental_cluster_pr_7"]').val('< 10<sup>th</sup>');
                                    $('#mental_cluster_pr_7 span').html('< 10<sup>th</sup>');
                                    $('input[name="mental_cluster_remarks_7"]').val('Delay');
                                    $('#mental_cluster_remarks_7 span').html('Delay');
                                    $('#mental_cluster_remarks_7').addClass('remarks-more-delay');
                                }
                                if (!mental_pr_stop_8) {
                                    $('input[name="mental_cluster_pr_8"]').val('< 10<sup>th</sup>');
                                    $('#mental_cluster_pr_8 span').html('< 10<sup>th</sup>');
                                    $('input[name="mental_cluster_remarks_8"]').val('Delay');
                                    $('#mental_cluster_remarks_8 span').html('Delay');
                                    $('#mental_cluster_remarks_8').addClass('remarks-more-delay');
                                }
                                if (!mental_pr_stop_9) {
                                    $('input[name="mental_cluster_pr_9"]').val('< 10<sup>th</sup>');
                                    $('#mental_cluster_pr_9 span').html('< 10<sup>th</sup>');
                                    $('input[name="mental_cluster_remarks_9"]').val('Delay');
                                    $('#mental_cluster_remarks_9 span').html('Delay');
                                    $('#mental_cluster_remarks_9').addClass('remarks-more-delay');
                                }
                                if (!mental_pr_stop_10) {
                                    $('input[name="mental_cluster_pr_10"]').val('< 10<sup>th</sup>');
                                    $('#mental_cluster_pr_10 span').html('< 10<sup>th</sup>');
                                    $('input[name="mental_cluster_remarks_10"]').val('Delay');
                                    $('#mental_cluster_remarks_10 span').html('Delay');
                                    $('#mental_cluster_remarks_10').addClass('remarks-more-delay');
                                }
                            }
                        }
                    }
                }
            }
        }
    }).addClass('bootbox-scale');
}
$('#collapseOne .reset').on('click', function() {
    var element = $(this).parents('tr');
    reset_trigger = true;
    element.find('.box-selection.selection-highlighter').removeClass('selection-highlighter').trigger('click');
});
$('#collapseTwo .reset').on('click', function() {
    var element = $(this).parents('tr');
    reset_trigger = true;
    element.find('.box-selection.selection-highlighter').removeClass('selection-highlighter').trigger('click');
});
$('input[name^="motor_cluster_remarks_"]').each(function() {
    var number = $(this).attr('name');
    number = number.replace(/[a-z_]/g, '');
    var remarks = $(this).val();
    var pr = $('input[name="motor_cluster_pr_' + number + '"]').val();
    if (remarks == 'Delay') {
        $(this).parent().addClass('remarks-more-delay');
    }
    if (pr.indexOf("10<sup>th</sup>") >= 0 || pr.indexOf("25<sup>th</sup>") >= 0) {
        $(this).parent().addClass('remarks-delay');
    }
});
$('input[name^="mental_cluster_remarks_"]').each(function() {
    var number = $(this).attr('name');
    number = number.replace(/[a-z_]/g, '');
    var remarks = $(this).val();
    var pr = $('input[name="mental_cluster_pr_' + number + '"]').val();
    if (remarks == 'Delay') {
        $(this).parent().addClass('remarks-more-delay');
    }
    if (pr.indexOf("10<sup>th</sup>") >= 0 || pr.indexOf("25<sup>th</sup>") >= 0) {
        $(this).parent().addClass('remarks-delay');
    }
});
</script>
