<style type="text/css">
    .m-chat-container .list-group {
        width: 100% !important;
    }

    .m-chat-container h5 {
        color: #444;
        font-size: 20px;
        text-align: center;
    }

    sup {
        font-size: xx-small;
        vertical-align: super;
    }

    .m-chat-container .list-group-item {
        margin-top: 10px;
        border-radius: none;
        background: #3968C6;
        cursor: default;
        transition: all 0.3s ease-in-out;
        font-size: 14px;
    }

    .m-chat-container .list-group-item:hover {
        transform: scaleX(1.03)
    }

    .about span {
        font-size: 12px;
        margin-right: 10px
    }

    .total-score-m-chat label {
        font-size: 16px !important;
    }

    @media (min-width: 768px) and (max-width: 1080px) {
        .m-chat-container .list-group {
            width: 88% !important;
        }
    }

    .box-selection {
        border: 1px solid white;
        padding: 5px 10px;
        cursor: pointer;
    }

    .selected-yes.selection-highlighter, .btn.selected-yes.selection-highlighter {
        background-color: #51a351;
    }

    .selected-no.selection-highlighter, .btn.selected-no.selection-highlighter {
        background-color: #bd362f;
    }

    .selected-more.selection-highlighter {
        background-color: #f0ad4e;
    }

    .btn.selected-yes.selection-highlighter {
        color: white;
        border: 1px solid white;
    }

    .btn.selected-no.selection-highlighter {
        color: white;
        border: 1px solid white;
    }

    .m-chat-container table td {
        border: none !important;
        color: white;
    }

    .separator {
        border-top: 1px solid white;
        padding-top: 10px;
    }

    .selected-yes.reverse.selection-highlighter {
        background-color: #bd362f;
    }

    .selected-no.reverse.selection-highlighter {
        background-color: #51a351;
    }
    #mchatscreening2 .reset {
        padding: 0px 3px;
        box-shadow: none;
        background-color: transparent;
        border: 0px;
        color: #000000;
    }
</style>
<div class="row">
    <div class="col-xs-12 text-right back-to-screeening">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
</div>
<div class="col-md-12">
    <div role="tabpanel" class="tabbable tabbable-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#mchatscreening1" aria-controls="mchatscreening1" role="tab" data-toggle="tab">M-CHAT-R</a>
            </li>
            <li role="presentation" class="hide" id="m-chat-followup-tab">
                <a href="#mchatscreening2" aria-controls="mchatscreening2" role="tab" data-toggle="tab">M-CHAT FOLLOW UP</a>
            </li>
        </ul>
        <div class="tab-content tab-view-shadow">
            <div role="tabpanel" class="tab-pane active" id="mchatscreening1">
                <div class="row m-chat-container">
                    <div class="col-xs-12">
                        <h6 class="total-score-m-chat text-center"><label class="label label-success">TOTAL M-CHAT-R SCORE: <span class="total_m_chat_score" id="total_m_chat_score"></span></label></h6>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>M-CHAT-R <sup>TM</sup></h5>
                            </div>
                        </div>
                        <div class="container d-flex justify-content-center">
                            <ul class="list-group mt-5 text-white">
                                @if(count($m_chat_questions) > 0)
                                @foreach($m_chat_questions as $ques_key => $ques_val)
                                <li class="list-group-item align-content-center">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-9 col-sm-9 col-xs-7">
                                            <div class="about">{{$ques_key+1}}. {{ $ques_val->question }}</div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-5 answer-input">
                                            <input type="hidden" name="answer[{{ $ques_val->id }}]" value="{{@$m_chat_results[$ques_val->id]}}" />
                                            @if ($ques_key == 1 || $ques_key == 4 || $ques_key == 11)
                                            <span class="m-chat-r box-selection selected-yes @if(@$m_chat_results[$ques_val->id] == 'Yes') selection-highlighter @endif reverse" id="selected_answer_{{ $ques_val->id }}" data-option="Yes" data-answer="{{ $ques_val->correct_answer }}" data-ques_id="{{ $ques_val->id }}">Yes</span><span class="m-chat-r box-selection selected-no @if(@$m_chat_results[$ques_val->id] == 'No') selection-highlighter @endif reverse" id="selected_answer_{{ $ques_val->id }}" data-option="No" data-answer="{{ $ques_val->correct_answer }}" data-ques_id="{{ $ques_val->id }}">No</span>
                                            @else
                                            <span class="m-chat-r box-selection selected-yes @if(@$m_chat_results[$ques_val->id] == 'Yes') selection-highlighter @endif" id="selected_answer_{{ $ques_val->id }}" data-option="Yes" data-answer="{{ $ques_val->correct_answer }}" data-ques_id="{{ $ques_val->id }}">Yes</span><span class="m-chat-r box-selection selected-no @if(@$m_chat_results[$ques_val->id] == 'No') selection-highlighter @endif" id="selected_answer_{{ $ques_val->id }}" data-option="No" data-answer="{{ $ques_val->correct_answer }}" data-ques_id="{{ $ques_val->id }}">No</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <h6 class="total-score-m-chat text-center"><label class="label label-success">TOTAL M-CHAT-R SCORE: <span class="total_m_chat_score"></span></label></h6>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label('m_chat_r_interpretation','Interpretation:') !!}
                        {!! Form::select('m_chat_r_interpretation', $m_chat_interpretation_options, null,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('m_chat_r_interpretation_others','Note:') !!}
                        {!! Form::textarea('m_chat_r_interpretation_others', null,['class'=>'form-control', 'rows'=>2]) !!}
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="mchatscreening2">
                <div class="row m-chat-container">
                    <div class="col-xs-12">
                        <h6 class="total-score-m-chat text-center"><label class="label label-success">TOTAL M-CHAT-FOLLOWUP SCORE: <span class="total_m_chat_followup_score" id="total_m_chat_followup_score"></span></label></h6>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>M-CHAT-FOLLOWUP <sup>TM</sup></h5>
                            </div>
                        </div>
                        <div class="container d-flex justify-content-center" id="m_chat_followup">
                            <ul class="list-group mt-5 text-white">
                                @if(count($m_chat_followup_questions) > 0)
                                @php $major_question = collect($m_chat_followup_questions)->where('stage', 1); @endphp
                                
                                <input type="hidden" name="followupanswer[23]" value="{{@$m_chat_followup_results[23]}}" data-val-copy="{{@$m_chat_followup_results[23]}}" />
                                <input type="hidden" name="followupanswer[24]" value="{{@$m_chat_followup_results[24]}}" data-val-copy="{{@$m_chat_followup_results[24]}}" />
                                <input type="hidden" name="followupanswer[25]" value="{{@$m_chat_followup_results[25]}}" data-val-copy="{{@$m_chat_followup_results[25]}}" />
                                <input type="hidden" name="followupanswer[26]" value="{{@$m_chat_followup_results[26]}}" data-val-copy="{{@$m_chat_followup_results[26]}}" />
                                <input type="hidden" name="followupanswer[27]" value="{{@$m_chat_followup_results[27]}}" data-val-copy="{{@$m_chat_followup_results[27]}}" />
                                <input type="hidden" name="followupanswer[28]" value="{{@$m_chat_followup_results[28]}}" data-val-copy="{{@$m_chat_followup_results[28]}}" />
                                <input type="hidden" name="followupanswer[29]" value="{{@$m_chat_followup_results[29]}}" data-val-copy="{{@$m_chat_followup_results[29]}}" />
                                <input type="hidden" name="followupanswer[30]" value="{{@$m_chat_followup_results[30]}}" data-val-copy="{{@$m_chat_followup_results[30]}}" />
                                <input type="hidden" name="followupanswer[33]" value="{{@$m_chat_followup_results[33]}}" data-val-copy="{{@$m_chat_followup_results[33]}}" />
                                <input type="hidden" name="followupanswer[34]" value="{{@$m_chat_followup_results[34]}}" data-val-copy="{{@$m_chat_followup_results[34]}}" />
                                <input type="hidden" name="followupanswer[35]" value="{{@$m_chat_followup_results[35]}}" data-val-copy="{{@$m_chat_followup_results[35]}}" />
                                <input type="hidden" name="followupanswer[37]" value="{{@$m_chat_followup_results[37] == 'No' ? 'No' : @$m_chat_followup_results[37]}}" data-val-copy="{{@$m_chat_followup_results[37] == 'No' ? 'No' : @$m_chat_followup_results[37]}}" />
                                <input type="hidden" name="followupanswer[38]" value="{{@$m_chat_followup_results[38] == 'No' ? 'No' : @$m_chat_followup_results[38]}}" data-val-copy="{{@$m_chat_followup_results[38] == 'No' ? 'No' : @$m_chat_followup_results[38]}}" />
                                <input type="hidden" name="followupanswer[39]" value="{{@$m_chat_followup_results[39] == 'No' ? 'No' : @$m_chat_followup_results[39]}}" data-val-copy="{{@$m_chat_followup_results[39] == 'No' ? 'No' : @$m_chat_followup_results[39]}}" />
                                <input type="hidden" name="followupanswer[41]" value="{{@$m_chat_followup_results[41]}}" data-val-copy="{{@$m_chat_followup_results[41]}}" />
                                <input type="hidden" name="followupanswer[42]" value="{{@$m_chat_followup_results[42]}}" data-val-copy="{{@$m_chat_followup_results[42]}}" />
                                <input type="hidden" name="followupanswer[43]" value="{{@$m_chat_followup_results[43]}}" data-val-copy="{{@$m_chat_followup_results[43]}}" />
                                <input type="hidden" name="followupanswer[44]" value="{{@$m_chat_followup_results[44]}}" data-val-copy="{{@$m_chat_followup_results[44]}}" />
                                <input type="hidden" name="followupanswer[45]" value="{{@$m_chat_followup_results[45]}}" data-val-copy="{{@$m_chat_followup_results[45]}}" />
                                <input type="hidden" name="followupanswer[46]" value="{{@$m_chat_followup_results[46]}}" data-val-copy="{{@$m_chat_followup_results[46]}}" />
                                <input type="hidden" name="followupanswer[47]" value="{{@$m_chat_followup_results[47]}}" data-val-copy="{{@$m_chat_followup_results[47]}}" />
                                <input type="hidden" name="followupanswer[48]" value="{{@$m_chat_followup_results[48]}}" data-val-copy="{{@$m_chat_followup_results[48]}}" />
                                <input type="hidden" name="followupanswer[49]" value="{{@$m_chat_followup_results[49]}}" data-val-copy="{{@$m_chat_followup_results[49]}}" />
                                <input type="hidden" name="followupanswer[50]" value="{{@$m_chat_followup_results[50]}}" data-val-copy="{{@$m_chat_followup_results[50]}}" />
                                <input type="hidden" name="followupanswer[51]" value="{{@$m_chat_followup_results[51]}}" data-val-copy="{{@$m_chat_followup_results[51]}}" />
                                <input type="hidden" name="followupanswer[53]" value="{{@$m_chat_followup_results[53]}}" data-val-copy="{{@$m_chat_followup_results[53]}}" />
                                <input type="hidden" name="followupanswer[54]" value="{{@$m_chat_followup_results[54]}}" data-val-copy="{{@$m_chat_followup_results[54]}}" />
                                <input type="hidden" name="followupanswer[55]" value="{{@$m_chat_followup_results[55]}}" data-val-copy="{{@$m_chat_followup_results[55]}}" />
                                <input type="hidden" name="followupanswer[56]" value="{{@$m_chat_followup_results[56]}}" data-val-copy="{{@$m_chat_followup_results[56]}}" />
                                <input type="hidden" name="followupanswer[58]" value="{{@$m_chat_followup_results[58]}}" data-val-copy="{{@$m_chat_followup_results[58]}}" />
                                <input type="hidden" name="followupanswer[59]" value="{{@$m_chat_followup_results[59]}}" data-val-copy="{{@$m_chat_followup_results[59]}}" />
                                <input type="hidden" name="followupanswer[60]" value="{{@$m_chat_followup_results[60]}}" data-val-copy="{{@$m_chat_followup_results[60]}}" />
                                <input type="hidden" name="followupanswer[61]" value="{{@$m_chat_followup_results[61]}}" data-val-copy="{{@$m_chat_followup_results[61]}}" />
                                <input type="hidden" name="followupanswer[62]" value="{{@$m_chat_followup_results[62]}}" data-val-copy="{{@$m_chat_followup_results[62]}}" />
                                <input type="hidden" name="followupanswer[63]" value="{{@$m_chat_followup_results[63]}}" data-val-copy="{{@$m_chat_followup_results[63]}}" />
                                <input type="hidden" name="followupanswer[64]" value="{{@$m_chat_followup_results[64]}}" data-val-copy="{{@$m_chat_followup_results[64]}}" />
                                <input type="hidden" name="followupanswer[65]" value="{{@$m_chat_followup_results[65]}}" data-val-copy="{{@$m_chat_followup_results[65]}}" />
                                <input type="hidden" name="followupanswer[67]" value="{{@$m_chat_followup_results[67]}}" data-val-copy="{{@$m_chat_followup_results[67]}}" />
                                <input type="hidden" name="followupanswer[68]" value="{{@$m_chat_followup_results[68]}}" data-val-copy="{{@$m_chat_followup_results[68]}}" />
                                <input type="hidden" name="followupanswer[69]" value="{{@$m_chat_followup_results[69]}}" data-val-copy="{{@$m_chat_followup_results[69]}}" />
                                <input type="hidden" name="followupanswer[70]" value="{{@$m_chat_followup_results[70]}}" data-val-copy="{{@$m_chat_followup_results[70]}}" />
                                <input type="hidden" name="followupanswer[71]" value="{{@$m_chat_followup_results[71]}}" data-val-copy="{{@$m_chat_followup_results[71]}}" />
                                <input type="hidden" name="followupanswer[73]" value="{{@$m_chat_followup_results[73]}}" data-val-copy="{{@$m_chat_followup_results[73]}}" />
                                <input type="hidden" name="followupanswer[74]" value="{{@$m_chat_followup_results[74]}}" data-val-copy="{{@$m_chat_followup_results[74]}}" />
                                <input type="hidden" name="followupanswer[75]" value="{{@$m_chat_followup_results[75]}}" data-val-copy="{{@$m_chat_followup_results[75]}}" />
                                <input type="hidden" name="followupanswer[76]" value="{{@$m_chat_followup_results[76]}}" data-val-copy="{{@$m_chat_followup_results[76]}}" />
                                <input type="hidden" name="followupanswer[77]" value="{{@$m_chat_followup_results[77]}}" data-val-copy="{{@$m_chat_followup_results[77]}}" />
                                <input type="hidden" name="followupanswer[78]" value="{{@$m_chat_followup_results[78]}}" data-val-copy="{{@$m_chat_followup_results[78]}}" />
                                <input type="hidden" name="followupanswer[79]" value="{{@$m_chat_followup_results[79]}}" data-val-copy="{{@$m_chat_followup_results[79]}}" />
                                <input type="hidden" name="followupanswer[80]" value="{{@$m_chat_followup_results[80]}}" data-val-copy="{{@$m_chat_followup_results[80]}}" />
                                <input type="hidden" name="followupanswer[82]" value="{{@$m_chat_followup_results[82]}}" data-val-copy="{{@$m_chat_followup_results[82]}}" />
                                <input type="hidden" name="followupanswer[83]" value="{{@$m_chat_followup_results[83]}}" data-val-copy="{{@$m_chat_followup_results[83]}}" />
                                <input type="hidden" name="followupanswer[84]" value="{{@$m_chat_followup_results[84]}}" data-val-copy="{{@$m_chat_followup_results[84]}}" />
                                <input type="hidden" name="followupanswer[85]" value="{{@$m_chat_followup_results[85]}}" data-val-copy="{{@$m_chat_followup_results[85]}}" />
                                <input type="hidden" name="followupanswer[86]" value="{{@$m_chat_followup_results[86]}}" data-val-copy="{{@$m_chat_followup_results[86]}}" />
                                <input type="hidden" name="followupanswer[87]" value="{{@$m_chat_followup_results[87]}}" data-val-copy="{{@$m_chat_followup_results[87]}}" />
                                <input type="hidden" name="followupanswer[88]" value="{{@$m_chat_followup_results[88]}}" data-val-copy="{{@$m_chat_followup_results[88]}}" />
                                <input type="hidden" name="followupanswer[89]" value="{{@$m_chat_followup_results[89]}}" data-val-copy="{{@$m_chat_followup_results[89]}}" />
                                <input type="hidden" name="followupanswer[91]" value="{{@$m_chat_followup_results[91]}}" data-val-copy="{{@$m_chat_followup_results[91]}}" />
                                <input type="hidden" name="followupanswer[92]" value="{{@$m_chat_followup_results[92]}}" data-val-copy="{{@$m_chat_followup_results[92]}}" />
                                <input type="hidden" name="followupanswer[93]" value="{{@$m_chat_followup_results[93]}}" data-val-copy="{{@$m_chat_followup_results[93]}}" />
                                <input type="hidden" name="followupanswer[94]" value="{{@$m_chat_followup_results[94]}}" data-val-copy="{{@$m_chat_followup_results[94]}}" />
                                <input type="hidden" name="followupanswer[95]" value="{{@$m_chat_followup_results[95]}}" data-val-copy="{{@$m_chat_followup_results[95]}}" />
                                <input type="hidden" name="followupanswer[96]" value="{{@$m_chat_followup_results[96]}}" data-val-copy="{{@$m_chat_followup_results[96]}}" />
                                <input type="hidden" name="followupanswer[97]" value="{{@$m_chat_followup_results[97]}}" data-val-copy="{{@$m_chat_followup_results[97]}}" />
                                <input type="hidden" name="followupanswer[100]" value="{{@$m_chat_followup_results[100]}}" data-val-copy="{{@$m_chat_followup_results[100]}}" />
                                <input type="hidden" name="followupanswer[101]" value="{{@$m_chat_followup_results[101]}}" data-val-copy="{{@$m_chat_followup_results[101]}}" />
                                <input type="hidden" name="followupanswer[102]" value="{{@$m_chat_followup_results[102]}}" data-val-copy="{{@$m_chat_followup_results[102]}}" />
                                <input type="hidden" name="followupanswer[103]" value="{{@$m_chat_followup_results[103]}}" data-val-copy="{{@$m_chat_followup_results[103]}}" />
                                <input type="hidden" name="followupanswer[104]" value="{{@$m_chat_followup_results[104]}}" data-val-copy="{{@$m_chat_followup_results[104]}}" />
                                <input type="hidden" name="followupanswer[105]" value="{{@$m_chat_followup_results[105]}}" data-val-copy="{{@$m_chat_followup_results[105]}}" />
                                <input type="hidden" name="followupanswer[106]" value="{{@$m_chat_followup_results[106]}}" data-val-copy="{{@$m_chat_followup_results[106]}}" />
                                <input type="hidden" name="followupanswer[107]" value="{{@$m_chat_followup_results[107]}}" data-val-copy="{{@$m_chat_followup_results[107]}}" />
                                <input type="hidden" name="followupanswer[109]" value="{{@$m_chat_followup_results[109]}}" data-val-copy="{{@$m_chat_followup_results[109]}}" />
                                <input type="hidden" name="followupanswer[110]" value="{{@$m_chat_followup_results[110]}}" data-val-copy="{{@$m_chat_followup_results[110]}}" />
                                <input type="hidden" name="followupanswer[111]" value="{{@$m_chat_followup_results[111]}}" data-val-copy="{{@$m_chat_followup_results[111]}}" />
                                <input type="hidden" name="followupanswer[112]" value="{{@$m_chat_followup_results[112]}}" data-val-copy="{{@$m_chat_followup_results[112]}}" />
                                <input type="hidden" name="followupanswer[113]" value="{{@$m_chat_followup_results[113]}}" data-val-copy="{{@$m_chat_followup_results[113]}}" />
                                <input type="hidden" name="followupanswer[114]" value="{{@$m_chat_followup_results[114]}}" data-val-copy="{{@$m_chat_followup_results[114]}}" />
                                <input type="hidden" name="followupanswer[115]" value="{{@$m_chat_followup_results[115]}}" data-val-copy="{{@$m_chat_followup_results[115]}}" />
                                <input type="hidden" name="followupanswer[116]" value="{{@$m_chat_followup_results[116]}}" data-val-copy="{{@$m_chat_followup_results[116]}}" />
                                <input type="hidden" name="followupanswer[117]" value="{{@$m_chat_followup_results[117]}}" data-val-copy="{{@$m_chat_followup_results[117]}}" />
                                <input type="hidden" name="followupanswer[118]" value="{{@$m_chat_followup_results[118]}}" data-val-copy="{{@$m_chat_followup_results[118]}}" />
                                <input type="hidden" name="followupanswer[119]" value="{{@$m_chat_followup_results[119]}}" data-val-copy="{{@$m_chat_followup_results[119]}}" />
                                <input type="hidden" name="followupanswer[120]" value="{{@$m_chat_followup_results[120]}}" data-val-copy="{{@$m_chat_followup_results[120]}}" />
                                <input type="hidden" name="followupanswer[121]" value="{{@$m_chat_followup_results[121]}}" data-val-copy="{{@$m_chat_followup_results[121]}}" />
                                <input type="hidden" name="followupanswer[122]" value="{{@$m_chat_followup_results[122]}}" data-val-copy="{{@$m_chat_followup_results[122]}}" />
                                <input type="hidden" name="followupanswer[123]" value="{{@$m_chat_followup_results[123]}}" data-val-copy="{{@$m_chat_followup_results[123]}}" />
                                <input type="hidden" name="followupanswer[124]" value="{{@$m_chat_followup_results[124]}}" data-val-copy="{{@$m_chat_followup_results[124]}}" />
                                <input type="hidden" name="followupanswer[125]" value="{{@$m_chat_followup_results[125]}}" data-val-copy="{{@$m_chat_followup_results[125]}}" />
                                <input type="hidden" name="followupanswer[126]" value="{{@$m_chat_followup_results[126]}}" data-val-copy="{{@$m_chat_followup_results[126]}}" />
                                <input type="hidden" name="followupanswer[128]" value="{{@$m_chat_followup_results[128]}}" data-val-copy="{{@$m_chat_followup_results[128]}}" />
                                <input type="hidden" name="followupanswer[129]" value="{{@$m_chat_followup_results[129]}}" data-val-copy="{{@$m_chat_followup_results[129]}}" />
                                <input type="hidden" name="followupanswer[130]" value="{{@$m_chat_followup_results[130]}}" data-val-copy="{{@$m_chat_followup_results[130]}}" />
                                <input type="hidden" name="followupanswer[131]" value="{{@$m_chat_followup_results[131]}}" data-val-copy="{{@$m_chat_followup_results[131]}}" />
                                <input type="hidden" name="followupanswer[132]" value="{{@$m_chat_followup_results[132]}}" data-val-copy="{{@$m_chat_followup_results[132]}}" />
                                <input type="hidden" name="followupanswer[133]" value="{{@$m_chat_followup_results[133]}}" data-val-copy="{{@$m_chat_followup_results[133]}}" />
                                <input type="hidden" name="followupanswer[134]" value="{{@$m_chat_followup_results[134]}}" data-val-copy="{{@$m_chat_followup_results[134]}}" />
                                <input type="hidden" name="followupanswer[135]" value="{{@$m_chat_followup_results[135]}}" data-val-copy="{{@$m_chat_followup_results[135]}}" />
                                <input type="hidden" name="followupanswer[136]" value="{{@$m_chat_followup_results[136]}}" data-val-copy="{{@$m_chat_followup_results[136]}}" />
                                <input type="hidden" name="followupanswer[137]" value="{{@$m_chat_followup_results[137]}}" data-val-copy="{{@$m_chat_followup_results[137]}}" />
                                <input type="hidden" name="followupanswer[138]" value="{{@$m_chat_followup_results[138]}}" data-val-copy="{{@$m_chat_followup_results[138]}}" />
                                <input type="hidden" name="followupanswer[139]" value="{{@$m_chat_followup_results[139]}}" data-val-copy="{{@$m_chat_followup_results[139]}}" />
                                <input type="hidden" name="followupanswer[140]" value="{{@$m_chat_followup_results[140]}}" data-val-copy="{{@$m_chat_followup_results[140]}}" />
                                <input type="hidden" name="followupanswer[141]" value="{{@$m_chat_followup_results[141]}}" data-val-copy="{{@$m_chat_followup_results[141]}}" />
                                <input type="hidden" name="followupanswer[142]" value="{{@$m_chat_followup_results[142]}}" data-val-copy="{{@$m_chat_followup_results[142]}}" />
                                <input type="hidden" name="followupanswer[143]" value="{{@$m_chat_followup_results[143]}}" data-val-copy="{{@$m_chat_followup_results[143]}}" />
                                <input type="hidden" name="followupanswer[145]" value="{{@$m_chat_followup_results[145]}}" data-val-copy="{{@$m_chat_followup_results[145]}}" />
                                <input type="hidden" name="followupanswer[146]" value="{{@$m_chat_followup_results[146]}}" data-val-copy="{{@$m_chat_followup_results[146]}}" />
                                <input type="hidden" name="followupanswer[147]" value="{{@$m_chat_followup_results[147]}}" data-val-copy="{{@$m_chat_followup_results[147]}}" />
                                <input type="hidden" name="followupanswer[148]" value="{{@$m_chat_followup_results[148]}}" data-val-copy="{{@$m_chat_followup_results[148]}}" />
                                <input type="hidden" name="followupanswer[149]" value="{{@$m_chat_followup_results[149]}}" data-val-copy="{{@$m_chat_followup_results[149]}}" />
                                <input type="hidden" name="followupanswer[150]" value="{{@$m_chat_followup_results[150]}}" data-val-copy="{{@$m_chat_followup_results[150]}}" />
                                <input type="hidden" name="followupanswer[151]" value="{{@$m_chat_followup_results[151]}}" data-val-copy="{{@$m_chat_followup_results[151]}}" />
                                <input type="hidden" name="followupanswer[168]" value="{{@$m_chat_followup_results[168]}}" data-val-copy="{{@$m_chat_followup_results[168]}}" />
                                <input type="hidden" name="followupanswer[169]" value="{{@$m_chat_followup_results[169]}}" data-val-copy="{{@$m_chat_followup_results[169]}}" />
                                <input type="hidden" name="followupanswer[170]" value="{{@$m_chat_followup_results[170]}}" data-val-copy="{{@$m_chat_followup_results[170]}}" />
                                <input type="hidden" name="followupanswer[171]" value="{{@$m_chat_followup_results[171]}}" data-val-copy="{{@$m_chat_followup_results[171]}}" />
                                <input type="hidden" name="followupanswer[172]" value="{{@$m_chat_followup_results[172]}}" data-val-copy="{{@$m_chat_followup_results[172]}}" />
                                <input type="hidden" name="followupanswer[173]" value="{{@$m_chat_followup_results[173]}}" data-val-copy="{{@$m_chat_followup_results[173]}}" />
                                <input type="hidden" name="followupanswer[153]" value="{{@$m_chat_followup_results[153]}}" data-val-copy="{{@$m_chat_followup_results[153]}}" />
                                <input type="hidden" name="followupanswer[154]" value="{{@$m_chat_followup_results[154]}}" data-val-copy="{{@$m_chat_followup_results[154]}}" />
                                <input type="hidden" name="followupanswer[155]" value="{{@$m_chat_followup_results[155]}}" data-val-copy="{{@$m_chat_followup_results[155]}}" />
                                <input type="hidden" name="followupanswer[156]" value="{{@$m_chat_followup_results[156]}}" data-val-copy="{{@$m_chat_followup_results[156]}}" />
                                <input type="hidden" name="followupanswer[157]" value="{{@$m_chat_followup_results[157]}}" data-val-copy="{{@$m_chat_followup_results[157]}}" />
                                <input type="hidden" name="followupanswer[174]" value="{{@$m_chat_followup_results[174]}}" data-val-copy="{{@$m_chat_followup_results[174]}}" />
                                <input type="hidden" name="followupanswer[177]" value="{{@$m_chat_followup_results[177]}}" data-val-copy="{{@$m_chat_followup_results[177]}}" />
                                <input type="hidden" name="followupanswer[178]" value="{{@$m_chat_followup_results[178]}}" data-val-copy="{{@$m_chat_followup_results[178]}}" />
                                <input type="hidden" name="followupanswer[179]" value="{{@$m_chat_followup_results[179]}}" data-val-copy="{{@$m_chat_followup_results[179]}}" />
                                <input type="hidden" name="followupanswer[180]" value="{{@$m_chat_followup_results[180]}}" data-val-copy="{{@$m_chat_followup_results[180]}}" />
                                <input type="hidden" name="followupanswer[181]" value="{{@$m_chat_followup_results[181]}}" data-val-copy="{{@$m_chat_followup_results[181]}}" />
                                <input type="hidden" name="followupanswer[158]" value="{{@$m_chat_followup_results[158]}}" data-val-copy="{{@$m_chat_followup_results[158]}}" />
                                <input type="hidden" name="followupanswer[159]" value="{{@$m_chat_followup_results[159]}}" data-val-copy="{{@$m_chat_followup_results[159]}}" />
                                <input type="hidden" name="followupanswer[160]" value="{{@$m_chat_followup_results[160]}}" data-val-copy="{{@$m_chat_followup_results[160]}}" />
                                <input type="hidden" name="followupanswer[161]" value="{{@$m_chat_followup_results[161]}}" data-val-copy="{{@$m_chat_followup_results[161]}}" />
                                <input type="hidden" name="followupanswer[163]" value="{{@$m_chat_followup_results[163]}}" data-val-copy="{{@$m_chat_followup_results[163]}}" />
                                <input type="hidden" name="followupanswer[164]" value="{{@$m_chat_followup_results[164]}}" data-val-copy="{{@$m_chat_followup_results[164]}}" />
                                <input type="hidden" name="followupanswer[165]" value="{{@$m_chat_followup_results[165]}}" data-val-copy="{{@$m_chat_followup_results[165]}}" />
                                <input type="hidden" name="followupanswer[166]" value="{{@$m_chat_followup_results[166]}}" data-val-copy="{{@$m_chat_followup_results[166]}}" />
                                @foreach($major_question as $ques_key => $ques_val)
                                <li class="list-group-item align-content-center" id="question{{$ques_key}}">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-9 col-sm-9 col-xs-7">
                                            <div class="about">{{$ques_key}}. {{ $ques_val->question }}</div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-5 display-flex">
                                            <input type="hidden" name="followupanswer[{{ $ques_val->id }}]" value="{{@$m_chat_followup_results[$ques_val->id]}}" data-val-copy="{{@$m_chat_followup_results[$ques_val->id]}}"/>
                                            <input type="hidden" name="final_answer[{{ $ques_val->id }}]" value="{{@$m_chat_followup_results_final_answer[$ques_val->id]}}" data-val-copy="{{@$m_chat_followup_results_final_answer[$ques_val->id]}}" />
                                            @if ($ques_key == 2 || $ques_key == 5 || $ques_key == 12)                                            
                                            <span class="btn box-selection selected-yes main-question reverse hide" data-option="Yes" data-answer="{{ $ques_val->correct_answer }}" data-question-id="followupanswer[{{ $ques_val->id }}]" disabled>Yes</span><span class="btn box-selection selected-no main-question reverse hide" data-option="No" data-answer="{{ $ques_val->correct_answer }}" data-question-id="followupanswer[{{ $ques_val->id }}]" disabled>No</span>
                                            @else
                                            <span class="btn box-selection selected-yes main-question hide" data-option="Yes" data-answer="{{ $ques_val->correct_answer }}" data-question-id="followupanswer[{{ $ques_val->id }}]" disabled>Yes</span><span class="btn box-selection selected-no main-question hide" data-option="No" data-answer="{{ $ques_val->correct_answer }}" data-question-id="followupanswer[{{ $ques_val->id }}]" disabled>No</span>
                                            @endif                                            
                                        </div>
                                        @if ($ques_val->id == 1)
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer1" id="followupanswer1-Yes" data-question-count="4">
                                                <h6 class="separator">PASS examples</h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[23]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[23]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[23]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[24]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[24]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[24]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[25]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[25]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[25]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[26]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[26]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[26]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer1" id="followupanswer1-No" data-question-count="3">
                                                <h6 class="separator">FAIL examples</h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[27]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[27]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[27]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[28]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[28]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[28]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[29]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[29]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[29]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer1 text-center" id="followupanswer1-Parital">
                                                <h6 class="separator">{{ $m_chat_followup_questions[30]->question }}</h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>
                                                            <div class="box-selection selected-yes sub-question-2" data-option="Yes" data-question-id="followupanswer[30]">{{ $m_chat_followup_questions[31]->question }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="box-selection selected-no sub-question-2" data-option="No" data-question-id="followupanswer[30]">{{ $m_chat_followup_questions[32]->question }}</div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer1-pass">PASS</h2>
                                                <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer1-fail">FAIL</h2>
                                            </div>
                                        @endif
                                        @if ($ques_val->id == 2)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer2" id="followupanswer2-Yes" data-question-count="2">
                                            <h6 class="separator">Does he/she...</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[33]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[33]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[33]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[34]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[34]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[34]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 followupanswer2" id="followupanswer2-answer">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer2-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer2-fail">FAIL</h2>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer2" id="followupanswer2-2">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[35]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question " data-option="Yes" data-question-id="followupanswer[35]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[35]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer2" id="followupanswer2-2-Yes">
                                            <h3 class="separator">ALSO ASK FOR ALL CHILDREN:</h3>
                                            <h6>{{ $m_chat_followup_questions[36]->question }}</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[37]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[37]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[37]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[38]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[38]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[38]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[39]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[39]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[39]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 3)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer3" id="followupanswer3-question">
                                            <h6 class="separator">Does he/she...</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[41]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[41]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[41]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[42]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[42]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[42]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[43]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[43]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[43]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[44]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[44]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[44]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[45]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[45]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[45]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[46]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[46]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[46]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[47]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[47]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[47]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[48]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[48]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[48]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[49]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[49]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[49]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[50]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[50]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[50]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[51]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[51]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[51]">No</span>
                                                    </td>
                                                </tr>
                                                <tr class="display-none" id="description_51">
                                                    <td colspan="2">{{ Form::textarea('description[51]', @$m_chat_followup_results_description[51], ['rows'=>2, 'cols'=>30]) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer3-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer3-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 4)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer4" id="followupanswer4-question">
                                            <h6 class="separator">Does he/she enjoy climbing on...</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[53]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[53]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[53]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[54]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[54]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[54]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[55]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[55]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[55]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[56]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[56]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[56]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer4-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer4-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 5)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer5" id="followupanswer5-question-pass" data-question-count="5">
                                            <h6 class="separator">Does he/she ever...<br/>(Below are PASS examples)</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[58]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[58]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[58]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[59]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[59]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[59]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer5" id="followupanswer5-question-fail" data-question-count="5">
                                            <h6 class="separator">Does he/she ever...<br/>(Below are FAIL examples)</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[60]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[60]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[60]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[61]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[61]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[61]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[62]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[62]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[62]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[63]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[63]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[63]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[64]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[64]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[64]">No</span>
                                                    </td>
                                                </tr>
                                                <tr class="display-none" id="description_64">
                                                    <td colspan="2">{{ Form::textarea('description[64]', @$m_chat_followup_results_description[64], ['rows'=>2, 'cols'=>30]) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer5" id="followupanswer5-question-fail-2" data-question-count="5">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[65]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[65]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[65]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer5-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer5-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 6)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer6" id="followupanswer6-question" data-question-count="6">
                                            <h6 class="separator">Does he/she...</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[67]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[67]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[67]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[68]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[68]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[68]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[69]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[69]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[69]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[70]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[70]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[70]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer6" id="followupanswer6-question-2" data-question-count="6">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[71]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[71]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[71]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer6-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer6-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 7)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer7" id="followupanswer7-question" data-question-count="7">
                                            <h6 class="separator">Does your child ever want you to see something interesting such as....</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[73]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[73]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[73]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[74]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[74]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[74]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[75]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[75]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[75]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[76]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[76]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[76]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer7" id="followupanswer7-question-2" data-question-count="7">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[77]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[77]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[77]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer7" id="followupanswer7-question-3" data-question-count="7">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[78]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[78]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[78]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer7-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer7-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 8)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  display-none followupanswer8" id="followupanswer8-question" data-question-count="8">
                                            <h6 class="separator"></h6>                                                
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[79]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[79]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[79]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer8" id="followupanswer8-no-question" data-question-count="8">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[80]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[80]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[80]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer8" id="followupanswer8-question-2" data-question-count="8">
                                            <h6 class="separator"></h6>                                                
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[82]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[82]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[82]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[83]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[83]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[83]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[84]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[84]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[84]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[85]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[85]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[85]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[86]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[86]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[86]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[87]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[87]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[87]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[88]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[88]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[88]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer8" id="followupanswer8-question-3" data-question-count="8">
                                            <h6 class="separator"></h6>                                                
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[89]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[89]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[89]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer8-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer8-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 9)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer9" id="followupanswer9-question" data-question-count="9">
                                            <h6 class="separator">Does your child sometimes bring you...</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[91]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[91]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[91]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[92]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[92]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[92]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[93]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[93]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[93]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[94]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[94]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[94]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[95]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[95]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[95]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[96]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[96]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[96]">No</span>
                                                    </td>
                                                </tr>
                                                <tr class="display-none" id="description_96">
                                                    <td colspan="2">{{ Form::textarea('description[96]', @$m_chat_followup_results_description[96], ['rows'=>2, 'cols'=>30]) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer9" id="followupanswer9-question-2" data-question-count="9">
                                            <h6 class="separator"></h6>                                                
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[97]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[97]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[97]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer9-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer9-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 10)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer10" id="followupanswer10-Yes-question" data-question-count="10">
                                            <h6 class="separator">Does he/she...<br/>(below are PASS responses)</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[100]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[100]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[100]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[101]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[101]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[101]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[102]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[102]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[102]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer10" id="followupanswer10-No-question" data-question-count="10">
                                            <h6 class="separator">Does he/she...<br/>(below are FAIL responses)</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[103]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[103]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[103]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[104]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[104]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[104]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[105]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[105]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[105]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[106]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[106]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[106]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer10" id="followupanswer10-question" data-question-count="10">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[107]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[107]">PASS</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[107]">FAIL</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer10-pass">PASS</h2>

                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer10-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 11)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer11" id="followupanswer11-pass-question" data-question-count="11">
                                            <h6 class="separator">Does your child...<br/>(Below are PASS examples)</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[109]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[109]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[109]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[110]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[110]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[110]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[111]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[111]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[111]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer11" id="followupanswer11-fail-question" data-question-count="11">
                                            <h6 class="separator">Does he/she ever...<br/>(Below are FAIL examples)</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[112]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[112]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[112]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[113]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[113]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[113]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[114]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[114]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[114]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer11" id="followupanswer11-question" data-question-count="11">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[115]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[115]">PASS</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[115]">FAIL</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer11-pass">PASS</h2>

                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer11-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 12)
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer12" id="followupanswer12-yes-question" data-question-count="12">
                                            <h6 class="separator">Does your child have a negative reaction to the sound of...</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[116]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[116]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[116]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[117]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[117]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[117]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[118]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[118]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[118]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[119]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[119]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[119]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[120]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[120]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[120]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[121]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[121]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[121]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[122]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[122]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[122]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[123]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[123]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[123]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[124]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[124]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[124]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[125]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[125]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[125]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[126]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[126]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[126]">No</span>
                                                    </td>
                                                </tr>
                                                <tr class="display-none" id="description_126">
                                                    <td colspan="2">{{ Form::textarea('description[126]', @$m_chat_followup_results_description[126], ['rows'=>2, 'cols'=>30]) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer12" id="followupanswer12-pass-question" data-question-count="12">
                                            <h6 class="separator">Does your child...<br/>(Below are PASS responses)</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[128]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[128]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[128]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[129]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[129]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[129]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer12" id="followupanswer12-fail-question" data-question-count="12">
                                            <h6 class="separator">Does your child...<br/>(Below are FAIL responses)</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[130]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[130]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[130]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[131]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[131]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[131]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[132]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[132]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[132]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer12" id="followupanswer12-question" data-question-count="12">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[133]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[133]">PASS</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[133]">FAIL</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer12-pass">PASS</h2>

                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer12-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 13)  
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer13" id="followupanswer13-question" data-question-count="13">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[134]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[134]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[134]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer13-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer13-fail">FAIL</h2>
                                        </div>
                                        @endif
                                        @if ($ques_val->id == 14)   
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer14" id="followupanswer14-yes-question" data-question-count="14">
                                            <h6 class="separator"></h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[135]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[135]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[135]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>  
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer14" id="followupanswer14-question" data-question-count="14">
                                            <h6 class="separator">Does he/she look you in the eye...</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[136]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[136]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[136]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[137]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[137]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[137]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[138]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[138]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[138]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[139]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[139]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[139]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[140]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[140]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[140]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[141]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[141]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[141]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer14" id="followupanswer14-question-2" data-question-count="14">
                                            <table class="table table-layout-fixed display-block separator">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[142]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[142]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[142]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer14" id="followupanswer14-question-3" data-question-count="14">
                                            <table class="table table-layout-fixed display-block separator">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[143]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[143]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[143]">No</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer14-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer14-fail">FAIL</h2>
                                        </div>   
                                        @endif
                                        @if ($ques_val->id == 15)    
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer15" id="followupanswer15-question" data-question-count="15">
                                            <h6 class="separator">Does your child try to copy you if you...</h6>
                                            <table class="table table-layout-fixed display-block">
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[145]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[145]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[145]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[146]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[146]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[146]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[147]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[147]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[147]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[148]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[148]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[148]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[149]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[149]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[149]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[150]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[150]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[150]">No</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ $m_chat_followup_questions[151]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                    <td>
                                                        <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[151]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[151]">No</span>
                                                    </td>
                                                </tr>
                                                <tr class="display-none" id="description_151">
                                                    <td colspan="2">{{ Form::textarea('description[151]', @$m_chat_followup_results_description[151], ['rows'=>2, 'cols'=>30]) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer15-pass">PASS</h2>
                                            <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer15-fail">FAIL</h2>
                                            </div>
                                            @endif
                                            @if ($ques_val->id == 16)
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer16" id="followupanswer16-pass-question" data-question-count="16">
                                                <h6 class="separator">Does your child...<br/>(Below are PASS responses)</h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[168]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[168]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[168]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[169]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[169]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[169]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[170]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[170]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[170]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 followupanswer16 display-none" id="followupanswer16-fail-question" data-question-count="16">
                                                <h6 class="separator">Does you child...<br/>(Below are FAIL responses)</h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[171]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[171]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[171]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[172]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[172]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[172]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer16" id="followupanswer16-question" data-question-count="16">
                                                <h6 class="separator"></h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[173]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[173]">PASS</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[173]">FAIL</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer16-pass">PASS</h2>

                                                <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer16-fail">FAIL</h2>
                                            </div>
                                            @endif
                                            @if ($ques_val->id == 17)   
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer17" id="followupanswer17-question" data-question-count="17">
                                                <h6 class="separator">Does he/she...</h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[153]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[153]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[153]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[154]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[154]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[154]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[155]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[155]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[155]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[156]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[156]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[156]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[157]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[157]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[157]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="display-none" id="description_157">
                                                        <td colspan="2">{{ Form::textarea('description[157]', @$m_chat_followup_results_description[157], ['rows'=>2, 'cols'=>30]) }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer17-pass">PASS</h2>
                                                <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer17-fail">FAIL</h2>
                                            </div>
                                            @endif
                                            @if ($ques_val->id == 18)                                        
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer18" id="followupanswer18-yes-question" data-question-count="18">
                                                <h6 class="separator">{{ $m_chat_followup_questions[174]->question }}
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>
                                                            <div class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[174]">{{ $m_chat_followup_questions[175]->question }}</div>
                                                        </td>
                                                        <td>
                                                            <div class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[174]">{{ $m_chat_followup_questions[176]->question }}</div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>                                       
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer18" id="followupanswer18-no-question" data-question-count="18">
                                                <h6 class="separator"></h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[177]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[177]">Yes</span><span class="box-selection selected-no sub-question"  data-option="No" data-question-id="followupanswer[177]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>                                       
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer18" id="followupanswer18-no-question-1" data-question-count="18">
                                                <h6 class="separator"></h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[178]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[178]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[178]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>                                      
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer18" id="followupanswer18-no-question-2" data-question-count="18">
                                                <h6 class="separator"><b>When the situation does not give any clues,</b> can he/she follow a command? For example... (ask until you get a yes or use all examples)</h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[179]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[179]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[179]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[180]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[180]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[180]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[181]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[181]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[181]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer18-pass">PASS</h2>
                                                <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer18-fail">FAIL</h2>
                                            </div>
                                            @endif
                                            @if ($ques_val->id == 19) 
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer19" id="followupanswer19-question" data-question-count="19">
                                                <h6 class="separator"></h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[158]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[158]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[158]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer19" id="followupanswer19-question-2" data-question-count="19">
                                                <h6 class="separator"></h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[159]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[159]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[159]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer19" id="followupanswer19-question-3" data-question-count="19">
                                                <h6 class="separator"></h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[160]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[160]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[160]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer19-pass">PASS</h2>
                                                <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer19-fail">FAIL</h2>
                                            </div>
                                            @endif
                                            @if ($ques_val->id == 20)   
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer20" id="followupanswer20-yes-question" data-question-count="20">
                                                <h6 class="separator"></h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[161]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[161]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[161]">No</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>   
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 display-none followupanswer20" id="followupanswer20-no-question-2" data-question-count="20">
                                                <h6 class="separator">Does your child try to copy you if you...</h6>
                                                <table class="table table-layout-fixed display-block">
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[163]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[163]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[163]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[164]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[164]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[164]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[165]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[165]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[165]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $m_chat_followup_questions[166]->question }} <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a></td>
                                                        <td>
                                                            <span class="box-selection selected-yes sub-question" data-option="Yes" data-question-id="followupanswer[166]">Yes</span><span class="box-selection selected-no sub-question" data-option="No" data-question-id="followupanswer[166]">No</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="display-none" id="description_166">
                                                        <td colspan="2">{{ Form::textarea('description[166]', @$m_chat_followup_results_description[166], ['rows'=>2, 'cols'=>30]) }}</td>
                                                    </tr>
                                                </table>
                                            </div>  
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h2 class="text-center btn-success display-none followupanswer-pass" id="followupanswer20-pass">PASS</h2>
                                                <h2 class="text-center btn-danger display-none followupanswer-fail" id="followupanswer20-fail">FAIL</h2>
                                            </div>
                                            @endif
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <h6 class="total-score-m-chat text-center"><label class="label label-success">TOTAL M-CHAT-FOLLOWUP SCORE: <span class="total_m_chat_followup_score"></span></label></h6>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            {!! Form::label('m_chat_followup_interpretation','Interpretation:') !!}
                            {!! Form::select('m_chat_followup_interpretation', $m_chat_interpretation_options, null,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('m_chat_followup_interpretation_others','Note:') !!}
                            {!! Form::textarea('m_chat_followup_interpretation_others', null,['class'=>'form-control', 'rows'=>2]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-right">
            <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
        </div>
    </div>
