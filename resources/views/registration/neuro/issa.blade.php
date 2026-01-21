<style type="text/css">
    #issa_form .list-group-item {
        margin-top: 10px;
        border-radius: none;
        cursor: default;
        transition: all 0.3s ease-in-out;
        font-size: 14px;
        color: black;
    }
    #issa_form .list-group-item:hover {
        transform: scaleX(1.03);
        background: #3968C6;
    }
    #issa_form .reset {
        padding: 0px 3px;
        box-shadow: none;
        background-color: transparent;
        border: 0px;
        color: #000000;
    }
    #issa_form .box-selection {
        border: 1px solid black;
        padding: 5px 10px;
        cursor: pointer;
        margin: -2px;
    }
    #issa_form .list-group-item:hover {
        color: white;
    } 
    #issa_form .list-group-item:hover .box-selection {
        border-color: white;
    }
    #issa_form .selection-highlighter {
        background-color: #3968C6;
        color: #FFFFFF;
    }
    #issa_form .selection-highlighter:hover {
        background-color: #FFFFFF;
        color: #000000;
    }
    /*#issa_form .selected-1.selection-highlighter {
        background-color: #FF0000;
    }
    #issa_form .selected-2.selection-highlighter {
        background-color: #FFA500;
    }
    #issa_form .selected-3.selection-highlighter, #issa_form .selected-4.selection-highlighter:hover {
        background-color: #FFFF00;
        color: black;
    }
    #issa_form .selected-4.selection-highlighter, #issa_form .selected-4.selection-highlighter:hover {
        background-color: #90EE90;
        color: black;
    }
    #issa_form .selected-5.selection-highlighter {
        background-color: #008000;
        color: white;
    }*/
    .label-mild {
        background-color: #ffb848;
        padding: 5px;
    }
    .bg-warningg {
        padding: 5px;        
    }
    .category-conatainer {
        border: 1px solid black;
        padding: 0px 15px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    .category-conatainer h3 {
        background: #ffb900 none repeat scroll 0 0;
        margin: 0px -15px;
        padding: 10px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .category-conatainer h3 span {
        padding: 11px;
        font-size: 16px !important;
        background: #0000008c;
        color: white;
        margin: -10px;
    }
    .issa_status {
        padding: 10px;
        font-size: 20px !important;
    }
    .issa_status.label-success, .issa_status.label-mild, .issa_status.bg-warningg, .issa_status.label-danger {
        color: white;
    }
</style>
<div class="row">
    <div class="col-xs-12 text-right back-to-screeening">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
</div>
<div class="col-md-12 mt-20">
    <div class="col-xs-12">
        <div class="d-flex justify-content-center">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-2 col-md-offset-1">
                    <h4><strong>1 = Rarely Up to 20%</strong></h4>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2">
                    <h4><strong>2 = Sometimes 21–40%</strong></h4>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2">
                    <h4><strong>3 = Frequently 41–60%</strong></h4>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2">
                    <h4><strong>4 = Mostly 61–80%</strong></h4>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-2">
                    <h4><strong>5 = Always 81–100%</strong></h4>
                </div>
            </div>
        </div>

    </div>
    @php $issa_problems = \ValuelistHelpers::issaQuestionTypes(); @endphp
    <div class="col-xs-12">
        {!! Form::hidden('srr', @$results->srr) !!}
        {!! Form::hidden('er', @$results->er) !!}
        {!! Form::hidden('slc', @$results->slc) !!}
        {!! Form::hidden('bp', @$results->bp) !!}
        {!! Form::hidden('sa', @$results->sa) !!}
        {!! Form::hidden('cc', @$results->cc) !!}
        {!! Form::hidden('total', @$results->total) !!}

        <h5 class="mt-15 text-center"><b><span class="issa_status"></span></b></h5>

        <div class="container d-flex justify-content-center">
            @if(count($issa_question) > 0)
            @foreach($issa_question as $category_id => $category)
            <div class="category-conatainer">
                <h3>
                    <b>{{$issa_problems[$category_id]}}</b>
                    <span class="pull-right">Score: 
                        @if ($category_id == 1)
                        <b id="srr-data">{!! @$results->srr !!}</b>
                        @elseif ($category_id == 2)
                        <b id="er-data">{!! @$results->er !!}</b>
                        @elseif ($category_id == 3)
                        <b id="slc-data">{!! @$results->slc !!}</b>
                        @elseif ($category_id == 4)
                        <b id="bp-data">{!! @$results->bp !!}</b>
                        @elseif ($category_id == 5)
                        <b id="sa-data">{!! @$results->sa !!}</b>
                        @elseif ($category_id == 6)
                        <b id="cc-data">{!! @$results->cc !!}</b>
                        @endif
                    </span>
                </h3>
                <ul class="list-group text-white">
                    @foreach($category as $key => $value)
                    @php $value = (object)$value; @endphp
                    <li class="list-group-item align-content-center">
                        <div class="row">
                            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-6">
                                <div class="about">
                                    {{ $value->id }}. {{ $value->question }}
                                    <a class="btn btn-default reset" title="Reset">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 answer-input" data-ques_id="{{ @$value->id }}" data-answer="{{ @$issa_answer[$value->id] }}" data-category="{{@$value->category}}">
                                {!! Form::hidden('issa_answer['.@$value->id.']', @$issa_answer[$value->id]) !!}
                                <span class="box-selection selected-1" data-option="1">1</span>
                                <span class="box-selection selected-2" data-option="2">2</span>
                                <span class="box-selection selected-3" data-option="3">3</span>
                                <span class="box-selection selected-4" data-option="4">4</span>
                                <span class="box-selection selected-5" data-option="5">5</span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
            @endif
        </div>
         {!! Form::hidden('issa_status') !!}
        <h5 class="mt-15 text-center"><b><span class="issa_status"></span></b></h5>
    </div>
</div>
