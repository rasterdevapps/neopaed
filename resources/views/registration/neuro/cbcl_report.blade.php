<style type="text/css">
#cbcl_form .list-group-item {
    margin-top: 10px;
    border-radius: none;
    background: #3968C6;
    cursor: default;
    transition: all 0.3s ease-in-out;
    font-size: 14px;
}

#cbcl_form .list-group-item:hover {
    transform: scaleX(1.03)
}
#cbcl_form .reset {
    padding: 0px 3px;
    box-shadow: none;
    background-color: transparent;
    border: 0px;
    color: #000000;
}
.selected-0.selection-highlighter {
    background-color: #51a351;
}
.selected-1.selection-highlighter {
    background-color: #f89406;
}
.selected-2.selection-highlighter {
    background-color: #bd362f;
}
#problem-container table {
    width: auto;
    margin: auto;
}
.cbcl-status-btn.label-success {
    background-color: #5cb85c;
    color: white;
}
.cbcl-status-btn.label-info {
    background-color: #2f96b4;
    color: white;
}
.cbcl-status-btn.label-warning {
    background-color: #f0ad4e;
    color: white;
}
#problem-container tr:first-child td:first-child {
    color: #E8456C;
}
#problem-container tr:nth-child(2) td:first-child {
    color: #F7CA63;
}
#problem-container tr:nth-child(3) td:first-child {
    color: #06CF9B;
}
#problem-container tr:nth-child(4) td:first-child {
    color: #ff00ec;
}
#problem-container tr:last-child td:first-child {
    color: #ac2828;
}
.category {
    position: absolute;
    height: 41px;
    width: 5px;
    top: -10px;
    left: 0px;
}
.category-1 {
    background-color: #E8456C;
}
.category-2 {
    background-color: #F7CA63;
}
.category-3 {
    background-color: #06CF9B;
}
.category-4 {
    background-color: #ff00ec;
}
.category-5 {
    background-color: #ac2828;
}
</style>
<div class="row">
    <div class="col-xs-12 text-right back-to-screeening">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
</div>
<div class="col-md-12">
    <div class="col-xs-12">
        <div class="container d-flex justify-content-center">
            <div class="col-xs-4"><h3><b>0 = Not True (as far as you know)</b></h3></div>
            <div class="col-xs-4"><h3><b>1 = Somewhat or Sometimes True</b></h3></div>
            <div class="col-xs-4"><h3><b>2 = Very True or Often True</b></h3></div>
        </div>
    </div>
    @php $cbcl_problems = \ValuelistHelpers::cbclQuestionTypes(); @endphp
    <div class="col-xs-12">
        <div class="container d-flex justify-content-center">
            <ul class="list-group mt-5 text-white">
                {!! Form::hidden('attective_problem', null, ['id' => 'problem_type_1']) !!}
                {!! Form::hidden('anxiety_problem', null, ['id' => 'problem_type_2']) !!}
                {!! Form::hidden('pervasive_developmental_problem', null, ['id' => 'problem_type_3']) !!}
                {!! Form::hidden('attention_deficit_hyperactivity_problem', null, ['id' => 'problem_type_4']) !!}
                {!! Form::hidden('oppositional_defiant_problem', null, ['id' => 'problem_type_5']) !!}
                @if(count($cbcl_question) > 0)
                @foreach($cbcl_question as $question_no => $values)
                <li class="list-group-item align-content-center">
                    <div class="row">
                        <div class="col-lg-10 col-md-9 col-sm-9 col-xs-7">
                            <div class="about">
                                @if ($values->category > 0)
                                    <span class="category category-{{$values->category}}" title="{{$cbcl_problems[$values->category]}}"></span>
                                @endif
                                {{ $values->id }}. {{ $values->question }}
                                <a class="btn btn-default reset" title="Reset">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-5 answer-input" data-ques_id="{{ $values->id }}" data-answer="{{ @$cbcl_result[$values->id]->answer }}" data-describe-status="{{$values->describe}}" data-problem="{{$values->category}}">
                            {!! Form::hidden('cbcl_answer['.$values->id.']', @$cbcl_result[$values->id]->answer) !!}
                            <span class="box-selection selected-0 selection-highlighter" data-option="0">0</span><span class="box-selection selected-1" data-option="1">1</span><span class="box-selection selected-2" data-option="2">2</span>
                        </div>
                        @if ($values->describe == 1)
                        <div class="col-xs-12 mt-15 hide textarea-container" id="describe-{{$values->id}}">
                            {!! Form::textarea('cbcl_describe['.$values->id.']', @$cbcl_result[$values->id]->description, ['class'=>'', 'rows'=>2, 'cols'=>50, 'placeholder'=>'Describe']) !!}
                        </div>
                        @endif
                    </div>
                </li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="col-xs-12" id="problem-container">
        <table class="table table-bordered d-flex justify-content-center">
            <thead>
                <tr>
                    <th>Problems</th>
                    <th>Range</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cbcl_problems as $key => $value)
                @if ($key > 0)
                <tr>
                    <td>{{ $value }}</td>
                    <td id="problem_range_{{ $key }}" class="input-width-xlarge"></td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>        
        <div class="col-md-12 text-center mt-15">
            <span class="display-block cbcl-status-btn label-success p-5 {{(@$results->cbcl_interpretation_status != '' && @$results->cbcl_interpretation_status == 0) ? '' : 'hide'}}"><b>Normal</b></span>
            <span class="display-block cbcl-status-btn label-info p-5 {{(@$results->cbcl_interpretation_status == 1) ? '' : 'hide'}}"><b>Borderline</b></span>
            <span class="display-block cbcl-status-btn label-warning p-5 {{(@$results->cbcl_interpretation_status == 2) ? '' : 'hide'}}"><b>Risk</b></span>
        </div>
        <div class="form-group row mt-15">
            {!! Form::label('cbcl_interpretation','Interpretation:', ['class'=>'required-label']) !!}
            {!! Form::text('cbcl_interpretation', null,['class'=>'form-control']) !!}
            {!! Form::hidden('cbcl_interpretation_status') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
</div>
