<style type="text/css">
    .hine-container .row-head
    {
        vertical-align: middle !important;
    }
    .hine-container .table td:not(.no-border), .hine-container .table th:not(.no-border)
    {
        border: 1px solid #888;
        border-collapse: collapse;
    }
    .hine-container .table th:not(.no-border)
    {
        border-top: 1px solid #888 !important;
    }
    .hine-container .table td
    {
        position: relative;
    }
    .hine-container .image-container
    {
        display: table-cell;
        position: absolute;
        bottom: 7px;
        left: 15%;
    }
    .hine-container .image-container img
    {
        vertical-align: bottom;
    }
    .hine-container .side-indication:before
    {
        position: absolute;
        bottom: -10px;
        left: -13px;
        content: 'R';
        font-size: 13px;
        font-weight: 600;
    }
    .hine-container .side-indication:after
    {
        position: absolute;
        bottom: -10px;
        right: -13px;
        content: 'L';
        font-size: 13px;
        font-weight: 600;
    }
    .hine-container .image-container i
    {
        display: block;
        text-align: center;
        font-size: 20px;
    }
    .hine-container .popliteal-angle .image-container
    {
        bottom: 30% !important;
        left: 30% !important;
    }
    .hine-container .popliteal-angle .image-container i
    {
        font-size: 13px;
    }
    .hine-container .arm-recoil td img
    {
        min-width: 125%;
    }
    .hine-container .posture td p, .leg-recoil td p 
    {
        padding-bottom: 30px !important;
    }
    .hine-container .ventral-suspension td p
    {
        padding-bottom: 40px !important;
    }
    .hine-container .head-lag td p
    {
        padding-bottom: 50px !important;
    }
    .hine-container .arm-traction td p, .hine-container .arm-recoil td p
    {
        padding-bottom: 70px !important;
    }
    .hine-container .bg-secondary
    {
        background-color: #d5d5d5;
    }
    .hine-container .no-border
    {
        border: 0px !important;
    }
    .hine-container .sub-table tbody td
    {
        padding: 3px 5px !important;
    }
    .hine-container .sub-table
    {
        margin-bottom: 0px !important;
    }
    .hine-container .selected-score
    {
        background-color: #d4f5ff;
        box-shadow: 0px 0px 10px #999;
        transition: all .1s ease;
    }
    .hine-container .valign-middle td
    {
        vertical-align: middle !important;
    }
    .hine-container .table-list
    {
        padding-left: 5px !important;
        padding-bottom: 80px;
    }
    .hine-container .table-responsive {
        border: 1px solid black;
        margin-bottom: 15px;
    } 
    .hine-container .table {
        margin-bottom: 0px !important;
    } 
    .hine-container h3 {
        color: white;
        background-color: var(--theme-color);
        margin: 0px;
        padding: 15px;
    }
    #hine_form .vertical-top {
        vertical-align: top !important;
    }
    #hine_form .btn-total {
        background-color: var(--theme-color);
        color: white;
        font-size: 16px;
        font-weight: bold;
    }
    #hine_form .reset {
        position: absolute;
        top: 0px;
        right: 0px;
        float: right;
        padding: 0px 3px;
        box-shadow: none;
        background-color: transparent;
        border: 0px;
        color: red;
    }
</style>
<div class="row">
    <div class="col-xs-12 text-right back-to-screeening">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
    <div class="col-md-12 text-center mtb-20">
        <input type="hidden" name="total_hine_score_copy" class="total_hine_score_input" value="@if(isset($hine_details->total_hine_score)){{ $hine_details->total_hine_score }}@endif">
        <label class="label label-success total-score-label">TOTAL HINE SCORE: <span class="total_hine_score"></span></label>
    </div>
</div>
<div class="col-md-12">
    <div id="hinescreening1">
        <div class="row hine-container">
            <h3><strong>ASSESSMENT OF CRANIAL NERVE FUNCTION</strong></h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Score 3</th>
                            <th>2</th>
                            <th>Score 1</th>
                            <th>Score 0</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Facial appearance</strong>
                                <p>(at rest and when crying or stimulated)</p>
                                <input type="hidden" name="hine_facial_appearance" value="@if(isset($hine_details->hine_facial_appearance)) {{ $hine_details->hine_facial_appearance }} @endif">
                                <input type="hidden" name="assessment_of_cranial[]" id="hine_facial_appearance" value="{{@$hine_details->hine_facial_appearance}}">
                            </td>
                            <td onclick="updateHINEScore('hine_facial_appearance', '3', this)" data-cell="hine_facial_appearance_3" class="hine_facial_appearance_field @if(isset($hine_details->hine_facial_appearance) && $hine_details->hine_facial_appearance == '3') selected-score @endif">
                                <p>Smiles or reacts to stimuli by closing eyes and grimacing</p>
                            </td>
                            <td onclick="updateHINEScore('hine_facial_appearance', '2', this)" data-cell="hine_facial_appearance_2" class="hine_facial_appearance_field @if(isset($hine_details->hine_facial_appearance) && $hine_details->hine_facial_appearance == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_facial_appearance', '1', this)" data-cell="hine_facial_appearance_1" class="hine_facial_appearance_field @if(isset($hine_details->hine_facial_appearance) && $hine_details->hine_facial_appearance == '1') selected-score @endif">
                                <p>Closes eyes but not tightly, poor facial expression</p>
                            </td>
                            <td onclick="updateHINEScore('hine_facial_appearance', '0', this)" data-cell="hine_facial_appearance_0" class="hine_facial_appearance_field @if(isset($hine_details->hine_facial_appearance) && $hine_details->hine_facial_appearance == '0') selected-score @endif">
                                <p>Expressionless, does not react to stimuli</p>
                            </td>
                            <td>
                                @php $hine_details->hine_facial_appearance_status = isset($hine_details->hine_facial_appearance_status) ? $hine_details->hine_facial_appearance_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_facial_appearance_status', 1, ($hine_details->hine_facial_appearance_status == 1 ? true : false)) }} Symmetric </span><br/>
                                <span class="avoid-wrap">{{ Form::radio('hine_facial_appearance_status', 2, ($hine_details->hine_facial_appearance_status == 2 ? true : false)) }} Asymmetric </span><br/>                                
                                {!! Form::textarea('hine_facial_asymmetric', @$hine_details->hine_facial_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_facial_appearance_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Eye movements</strong>
                                <input type="hidden" name="hine_eye_movements" value="@if(isset($hine_details->hine_eye_movements)) {{ $hine_details->hine_eye_movements }} @endif">
                                <input type="hidden" name="assessment_of_cranial[]" id="hine_eye_movements" value="{{@$hine_details->hine_eye_movements}}">
                            </td>
                            <td onclick="updateHINEScore('hine_eye_movements', '3', this)" data-cell="hine_eye_movements_3" class="hine_eye_movements_field @if(isset($hine_details->hine_eye_movements) && $hine_details->hine_eye_movements == '3') selected-score @endif">
                                <p>Normal conjugate eye movements</p>
                            </td>
                            <td onclick="updateHINEScore('hine_eye_movements', '2', this)" data-cell="hine_eye_movements_2" class="hine_eye_movements_field @if(isset($hine_details->hine_eye_movements) && $hine_details->hine_eye_movements == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_eye_movements', '1', this)" data-cell="hine_eye_movements_1" class="hine_eye_movements_field @if(isset($hine_details->hine_eye_movements) && $hine_details->hine_eye_movements == '1') selected-score @endif">
                                <p><strong>Intermittent</strong> Deviation of eyes or abnormal movements</p>
                            </td>
                            <td onclick="updateHINEScore('hine_eye_movements', '0', this)" data-cell="hine_eye_movements_0" class="hine_eye_movements_field @if(isset($hine_details->hine_eye_movements) && $hine_details->hine_eye_movements == '0') selected-score @endif">
                                <p><strong>Continuous</strong> Deviation of eyes or abnormal movements</p>
                            </td>
                            <td>
                                @php $hine_details->hine_eye_movements_status = isset($hine_details->hine_eye_movements_status) ? $hine_details->hine_eye_movements_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_eye_movements_status', 1, ($hine_details->hine_eye_movements_status == 1 ? true : false)) }} Symmetric </span><br/>
                                <span class="avoid-wrap">{{ Form::radio('hine_eye_movements_status', 2, ($hine_details->hine_eye_movements_status == 2 ? true : false)) }} Asymmetric </span><br/>                                
                                {!! Form::textarea('hine_eye_asymmetric', @$hine_details->hine_eye_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_eye_movements_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Visual response</strong>
                                <p>Test ability to follow a black/white target</p>
                                <input type="hidden" name="hine_visual_response" value="@if(isset($hine_details->hine_visual_response)) {{ $hine_details->hine_visual_response }} @endif">
                                <input type="hidden" name="assessment_of_cranial[]" id="hine_visual_response" value="{{@$hine_details->hine_visual_response}}">
                            </td>
                            <td onclick="updateHINEScore('hine_visual_response', '3', this)" data-cell="hine_visual_response_3" class="hine_visual_response_field @if(isset($hine_details->hine_visual_response) && $hine_details->hine_visual_response == '3') selected-score @endif">
                                <p>Follows the target in a complete arc</p>
                            </td>
                            <td onclick="updateHINEScore('hine_visual_response', '2', this)" data-cell="hine_visual_response_2" class="hine_visual_response_field @if(isset($hine_details->hine_visual_response) && $hine_details->hine_visual_response == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_visual_response', '1', this)" data-cell="hine_visual_response_1" class="hine_visual_response_field @if(isset($hine_details->hine_visual_response) && $hine_details->hine_visual_response == '1') selected-score @endif">
                                <p>Follows target in an incomplete or asymmetrical arc</p>
                            </td>
                            <td onclick="updateHINEScore('hine_visual_response', '0', this)" data-cell="hine_visual_response_0" class="hine_visual_response_field @if(isset($hine_details->hine_visual_response) && $hine_details->hine_visual_response == '0') selected-score @endif">
                                <p>Does not follow the target</p>
                            </td>
                            <td>
                                @php $hine_details->hine_visual_response_status = isset($hine_details->hine_visual_response_status) ? $hine_details->hine_visual_response_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_visual_response_status', 1, ($hine_details->hine_visual_response_status == 1 ? true : false)) }} Symmetric </span><br/>
                                <span class="avoid-wrap">{{ Form::radio('hine_visual_response_status', 2, ($hine_details->hine_visual_response_status == 2 ? true : false)) }} Asymmetric </span><br/>                                
                                {!! Form::textarea('hine_visual_asymmetric', @$hine_details->hine_visual_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_visual_response_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Auditory response</strong>
                                <p>Test the response to a rattle</p>
                                <input type="hidden" name="hine_auditory_response" value="@if(isset($hine_details->hine_auditory_response)) {{ $hine_details->hine_auditory_response }} @endif">
                                <input type="hidden" name="assessment_of_cranial[]" id="hine_auditory_response" value="{{@$hine_details->hine_auditory_response}}">
                            </td>
                            <td onclick="updateHINEScore('hine_auditory_response', '3', this)" data-cell="hine_auditory_response_3" class="hine_auditory_response_field @if(isset($hine_details->hine_auditory_response) && $hine_details->hine_auditory_response == '3') selected-score @endif">
                                <p>Reacts to stimuli from both sides</p>
                            </td>
                            <td onclick="updateHINEScore('hine_auditory_response', '2', this)" data-cell="hine_auditory_response_2" class="hine_auditory_response_field @if(isset($hine_details->hine_auditory_response) && $hine_details->hine_auditory_response == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_auditory_response', '1', this)" data-cell="hine_auditory_response_1" class="hine_auditory_response_field @if(isset($hine_details->hine_auditory_response) && $hine_details->hine_auditory_response == '1') selected-score @endif">
                                <p>Doubtful reaction to stimuli or asymmetry of response</p>
                            </td>
                            <td onclick="updateHINEScore('hine_auditory_response', '0', this)" data-cell="hine_auditory_response_0" class="hine_auditory_response_field @if(isset($hine_details->hine_auditory_response) && $hine_details->hine_auditory_response == '0') selected-score @endif">
                                <p>No response</p>
                            </td>
                            <td>
                                @php $hine_details->hine_auditory_response_status = isset($hine_details->hine_auditory_response_status) ? $hine_details->hine_auditory_response_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_auditory_response_status', 1, ($hine_details->hine_auditory_response_status == 1 ? true : false)) }} Symmetric </span><br/>
                                <span class="avoid-wrap">{{ Form::radio('hine_auditory_response_status', 2, ($hine_details->hine_auditory_response_status == 2 ? true : false)) }} Asymmetric </span><br/>                               
                                {!! Form::textarea('hine_auditory_asymmetric', @$hine_details->hine_auditory_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_auditory_response_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Sucking/swallowing</strong>
                                <p>Watch infant suck on breast or bottle. If older, ask about feeding, assoc. cough, excessive dribbling</p>
                                <input type="hidden" name="hine_sucking_swallowing" value="@if(isset($hine_details->hine_sucking_swallowing)) {{ $hine_details->hine_sucking_swallowing }} @endif">
                                <input type="hidden" name="assessment_of_cranial[]" id="hine_sucking_swallowing" value="{{@$hine_details->hine_sucking_swallowing}}">
                            </td>
                            <td onclick="updateHINEScore('hine_sucking_swallowing', '3', this)" data-cell="hine_sucking_swallowing_3" class="hine_sucking_swallowing_field @if(isset($hine_details->hine_sucking_swallowing) && $hine_details->hine_sucking_swallowing == '3') selected-score @endif">
                                <p>Good suck and swallowing</p>
                            </td>
                            <td onclick="updateHINEScore('hine_sucking_swallowing', '2', this)" data-cell="hine_sucking_swallowing_2" class="hine_sucking_swallowing_field @if(isset($hine_details->hine_sucking_swallowing) && $hine_details->hine_sucking_swallowing == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_sucking_swallowing', '1', this)" data-cell="hine_sucking_swallowing_1" class="hine_sucking_swallowing_field @if(isset($hine_details->hine_sucking_swallowing) && $hine_details->hine_sucking_swallowing == '1') selected-score @endif">
                                <p>Poor suck and/or swallow</p>
                            </td>
                            <td onclick="updateHINEScore('hine_sucking_swallowing', '0', this)" data-cell="hine_sucking_swallowing_0" class="hine_sucking_swallowing_field @if(isset($hine_details->hine_sucking_swallowing) && $hine_details->hine_sucking_swallowing == '0') selected-score @endif">
                                <p>No sucking reflex, no swallowing</p>
                            </td>
                            <td>
                                @php $hine_details->hine_sucking_swallowing_status = isset($hine_details->hine_sucking_swallowing_status) ? $hine_details->hine_sucking_swallowing_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_sucking_swallowing_status', 1, ($hine_details->hine_sucking_swallowing_status == 1 ? true : false)) }} Symmetric </span><br/>
                                <span class="avoid-wrap">{{ Form::radio('hine_sucking_swallowing_status', 2, ($hine_details->hine_sucking_swallowing_status == 2 ? true : false)) }} Asymmetric </span><br/>                                                           
                                {!! Form::textarea('hine_sucking_asymmetric', @$hine_details->hine_sucking_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_sucking_swallowing_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hinescreening2">
        <div class="row hine-container mt-10">
            <h3><strong>ASSESSMENT OF POSTURE (note any asymmetries)</strong></h3>
            <div class="table-responsive">
                <table class="table valign-middle">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Score 3</th>
                            <th>2</th>
                            <th>Score 1</th>
                            <th>Score 0</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Head</strong>
                                <p>(in sitting)</p>
                                <input type="hidden" name="hine_head" value="@if(isset($hine_details->hine_head)) {{ $hine_details->hine_head }} @endif">
                                <input type="hidden" name="assessment_of_posture[]" id="hine_head" value="{{@$hine_details->hine_head}}">
                            </td>
                            <td onclick="updateHINEScore('hine_head', '3', this)" data-cell="hine_head_3" class="hine_head_field text-center @if(isset($hine_details->hine_head) && $hine_details->hine_head == '3') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/head-1.svg" class="img" />
                                <p>Straight; in midline</p>
                            </td>
                            <td onclick="updateHINEScore('hine_head', '2', this)" data-cell="hine_head_2" class="hine_head_field text-center @if(isset($hine_details->hine_head) && $hine_details->hine_head == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_head', '1', this)" data-cell="hine_head_1" class="hine_head_field text-center @if(isset($hine_details->hine_head) && $hine_details->hine_head == '1') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/head-3.svg" class="img" />
                                <p>Slightly to side or backward or forward</p>
                            </td>
                            <td onclick="updateHINEScore('hine_head', '0', this)" data-cell="hine_head_0" class="hine_head_field text-center @if(isset($hine_details->hine_head) && $hine_details->hine_head == '0') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/head-4.svg" class="img" />
                                <p>Markedly to side or backward or forward</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_head_status = isset($hine_details->hine_head_status) ? $hine_details->hine_head_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_head_status', 1, ($hine_details->hine_head_status == 1 ? true : false)) }} Symmetric </span><br/>
                                <span class="avoid-wrap">{{ Form::radio('hine_head_status', 2, ($hine_details->hine_head_status == 2 ? true : false)) }} Asymmetric </span><br/>                            
                                {!! Form::textarea('hine_head_asymmetric', @$hine_details->hine_head_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_head_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Trunk</strong>
                                <p>(in sitting)</p>
                                <input type="hidden" name="hine_trunk" value="@if(isset($hine_details->hine_trunk)) {{ $hine_details->hine_trunk }} @endif">
                                <input type="hidden" name="assessment_of_posture[]" id="hine_trunk" value="{{@$hine_details->hine_trunk}}">
                            </td>
                            <td onclick="updateHINEScore('hine_trunk', '3', this)" data-cell="hine_trunk_3" class="hine_trunk_field text-center @if(isset($hine_details->hine_trunk) && $hine_details->hine_trunk == '3') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/trunk-1.svg" class="img" />
                                <p>Straight</p>
                            </td>
                            <td onclick="updateHINEScore('hine_trunk', '2', this)" data-cell="hine_trunk_2" class="hine_trunk_field text-center @if(isset($hine_details->hine_trunk) && $hine_details->hine_trunk == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_trunk', '1', this)" data-cell="hine_trunk_1" class="hine_trunk_field text-center @if(isset($hine_details->hine_trunk) && $hine_details->hine_trunk == '1') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/trunk-3.svg" class="img" />
                                <p>Slightly curved or bent to side</p>
                            </td>
                            <td onclick="updateHINEScore('hine_trunk', '0', this)" data-cell="hine_trunk_0" class="hine_trunk_field text-center @if(isset($hine_details->hine_trunk) && $hine_details->hine_trunk == '0') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/trunk-4.svg" class="img" />
                                <br>
                                <span>Very rounded</span> |
                                <span>rocketing back</span> |
                                <span>bent sideway</span>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_trunk_status = isset($hine_details->hine_trunk_status) ? $hine_details->hine_trunk_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_trunk_status', 1, ($hine_details->hine_trunk_status == 1 ? true : false)) }} Symmetric </span><br/>
                                <span class="avoid-wrap">{{ Form::radio('hine_trunk_status', 2, ($hine_details->hine_trunk_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_trunk_asymmetric', @$hine_details->hine_trunk_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_trunk_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Arms</strong>
                                <p>(at rest)</p>
                                <input type="hidden" name="hine_arms" value="@if(isset($hine_details->hine_arms)) {{ $hine_details->hine_arms }} @endif">
                                <input type="hidden" name="assessment_of_posture[]" id="hine_arms" value="{{@$hine_details->hine_arms}}">
                            </td>
                            <td onclick="updateHINEScore('hine_arms', '3', this)" data-cell="hine_arms_3" class="hine_arms_field text-center @if(isset($hine_details->hine_arms) && $hine_details->hine_arms == '3') selected-score @endif">
                                <p>In a neutral position, central straight or slightly bent</p>
                            </td>
                            <td onclick="updateHINEScore('hine_arms', '2', this)" data-cell="hine_arms_2" class="hine_arms_field text-center @if(isset($hine_details->hine_arms) && $hine_details->hine_arms == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_arms', '1', this)" data-cell="hine_arms_1" class="hine_arms_field text-center @if(isset($hine_details->hine_arms) && $hine_details->hine_arms == '1') selected-score @endif">
                                <p><strong>Slight</strong> internal rotation or external rotation</p>
                                <p><strong>Intermittent</strong> dystonic posture</p>
                            </td>
                            <td onclick="updateHINEScore('hine_arms', '0', this)" data-cell="hine_arms_0" class="hine_arms_field text-center @if(isset($hine_details->hine_arms) && $hine_details->hine_arms == '0') selected-score @endif">
                                <p><strong>Marked</strong> internal rotation or external rotation or</p>
                                <p>dystonic posture, hemiplegic posture</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_arms_status = isset($hine_details->hine_arms_status) ? $hine_details->hine_arms_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_arms_status', 1, ($hine_details->hine_arms_status == 1 ? true : false)) }} Symmetric </span><br/>
                                <span class="avoid-wrap">{{ Form::radio('hine_arms_status', 2, ($hine_details->hine_arms_status == 2 ? true : false)) }} Asymmetric </span><br/>                            
                                {!! Form::textarea('hine_arms_asymmetric', @$hine_details->hine_arms_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_arms_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Hands</strong>
                                <input type="hidden" name="hine_hands" value="@if(isset($hine_details->hine_hands)) {{ $hine_details->hine_hands }} @endif">
                                <input type="hidden" name="assessment_of_posture[]" id="hine_hands" value="{{@$hine_details->hine_hands}}">
                            </td>
                            <td onclick="updateHINEScore('hine_hands', '3', this)" data-cell="hine_hands_3" class="hine_hands_field text-center @if(isset($hine_details->hine_hands) && $hine_details->hine_hands == '3') selected-score @endif">
                                <p>Hands open</p>
                            </td>
                            <td onclick="updateHINEScore('hine_hands', '2', this)" data-cell="hine_hands_2" class="hine_hands_field text-center @if(isset($hine_details->hine_hands) && $hine_details->hine_hands == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_hands', '1', this)" data-cell="hine_hands_1" class="hine_hands_field text-center @if(isset($hine_details->hine_hands) && $hine_details->hine_hands == '1') selected-score @endif">
                                <p><strong>Intermittent</strong> adducted thumb or fisting</p>
                            </td>
                            <td onclick="updateHINEScore('hine_hands', '0', this)" data-cell="hine_hands_0" class="hine_hands_field text-center @if(isset($hine_details->hine_hands) && $hine_details->hine_hands == '0') selected-score @endif">
                                <p><strong>Persistent</strong> adducted thumb or fisting</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_hands_status = isset($hine_details->hine_hands_status) ? $hine_details->hine_hands_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_hands_status', 1, ($hine_details->hine_hands_status == 1 ? true : false)) }} Symmetric </span><br/>
                                <span class="avoid-wrap">{{ Form::radio('hine_hands_status', 2, ($hine_details->hine_hands_status == 2 ? true : false)) }} Asymmetric </span><br/>                            
                                {!! Form::textarea('hine_hands_asymmetric', @$hine_details->hine_hands_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_hands_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Legs</strong>
                                <p>in sitting</p>
                                <br>
                                <br>
                                <br>
                                <p>in supine and in standing</p>
                                <input type="hidden" name="hine_legs" value="@if(isset($hine_details->hine_legs)) {{ $hine_details->hine_legs }} @endif">
                                <input type="hidden" name="assessment_of_posture[]" id="hine_legs" value="{{@$hine_details->hine_legs}}">
                            </td>
                            <td onclick="updateHINEScore('hine_legs', '3', this)" data-cell="hine_legs_3" class="hine_legs_field text-center @if(isset($hine_details->hine_legs) && $hine_details->hine_legs == '3') selected-score @endif">
                                <p>Able to sit with a straight back and legs straight or slightly bent (long sitting)</p>
                                <img src="{{ url('/') }}/public/img/hine/legs-1.svg" class="img" />
                                <p>Legs in neutral position straight or slightly bent</p>
                            </td>
                            <td onclick="updateHINEScore('hine_legs', '2', this)" data-cell="hine_legs_2" class="hine_legs_field text-center @if(isset($hine_details->hine_legs) && $hine_details->hine_legs == '2') selected-score @endif">
                                <p><strong>Slight</strong> internal rotation or external rotation</p>
                            </td>
                            <td onclick="updateHINEScore('hine_legs', '1', this)" data-cell="hine_legs_1" class="hine_legs_field text-center @if(isset($hine_details->hine_legs) && $hine_details->hine_legs == '1') selected-score @endif">
                                <p>Sit with straight back but knees bent at 15-20 °</p>
                                <img src="{{ url('/') }}/public/img/hine/legs-3.svg" class="img" />
                                <p>Internal rotation or external rotation at the hips</p>
                            </td>
                            <td onclick="updateHINEScore('hine_legs', '0', this)" data-cell="hine_legs_0" class="hine_legs_field text-center @if(isset($hine_details->hine_legs) && $hine_details->hine_legs == '0') selected-score @endif">
                                <p>Unable to sit straight unless knees markedly bent (no long sitting)</p>
                                <img src="{{ url('/') }}/public/img/hine/legs-4.svg" class="img" />
                                <p><strong>Marked</strong> internal rotation or external rotation or fixed extension or flexion or contractures at hips and knees</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_legs_status = isset($hine_details->hine_legs_status) ? $hine_details->hine_legs_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_legs_status', 1, ($hine_details->hine_legs_status == 1 ? true : false)) }} Symmetric </span><br/>
                                <span class="avoid-wrap">{{ Form::radio('hine_legs_status', 2, ($hine_details->hine_legs_status == 2 ? true : false)) }} Asymmetric </span><br/>                                                            
                                {!! Form::textarea('hine_legs_asymmetric', @$hine_details->hine_legs_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_legs_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Feet</strong>
                                <p>in supine and in standing</p>
                                <input type="hidden" name="hine_feet" value="@if(isset($hine_details->hine_feet)) {{ $hine_details->hine_feet }} @endif">
                                <input type="hidden" name="assessment_of_posture[]" id="hine_feet" value="{{@$hine_details->hine_feet}}">
                            </td>
                            <td onclick="updateHINEScore('hine_feet', '3', this)" data-cell="hine_feet_3" class="hine_feet_field text-center @if(isset($hine_details->hine_feet) && $hine_details->hine_feet == '3') selected-score @endif">
                                <p>Central in neutral position</p>
                                <br>
                                <p>Toes straight midway between flexion and extension</p>
                            </td>
                            <td onclick="updateHINEScore('hine_feet', '2', this)" data-cell="hine_feet_2" class="hine_feet_field text-center @if(isset($hine_details->hine_feet) && $hine_details->hine_feet == '2') selected-score @endif"></td>
                            <td onclick="updateHINEScore('hine_feet', '1', this)" data-cell="hine_feet_1" class="hine_feet_field text-center @if(isset($hine_details->hine_feet) && $hine_details->hine_feet == '1') selected-score @endif">
                                <p><strong>Slight</strong> internal rotation or external rotation</p>
                                <p><strong>Intermittent</strong> Tendency to stand on tiptoes or toes up or curling under</p>
                            </td>
                            <td onclick="updateHINEScore('hine_feet', '0', this)" data-cell="hine_feet_0" class="hine_feet_field text-center @if(isset($hine_details->hine_feet) && $hine_details->hine_feet == '0') selected-score @endif">
                                <p><strong>Marked</strong> internal rotation or external rotation at the ankle</p>
                                <p><strong>Persistent</strong> Tendency to stand on tiptoes or toes up or curling under</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_feet_status = isset($hine_details->hine_feet_status) ? $hine_details->hine_feet_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_feet_status', 1, ($hine_details->hine_feet_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_feet_status', 2, ($hine_details->hine_feet_status == 2 ? true : false)) }} Asymmetric </span><br/>                                                                                            
                                {!! Form::textarea('hine_feet_asymmetric', @$hine_details->hine_feet_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_feet_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hinescreening3">
        <div class="row hine-container mt-10">
            <h3><strong>ASSESSMENT OF MOVEMENTS</strong></h3>
            <div class="table-responsive">
                <table class="table valign-middle">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Score 3</th>
                            <th>2</th>
                            <th>Score 1</th>
                            <th>Score 0</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Quantity</strong>
                                <p>Watch infant lying in supine</p>
                                <input type="hidden" name="hine_quantity" value="@if(isset($hine_details->hine_quantity)) {{ $hine_details->hine_quantity }} @endif">
                                <input type="hidden" name="assessment_of_movements[]" id="hine_quantity" value="{{@$hine_details->hine_quantity}}">
                            </td>
                            <td onclick="updateHINEScore('hine_quantity', '3', this)" data-cell="hine_quantity_3" class="hine_quantity_field text-center @if(isset($hine_details->hine_quantity) && $hine_details->hine_quantity == '3') selected-score @endif">
                                <p>Normal</p>
                            </td>
                            <td onclick="updateHINEScore('hine_quantity', '2', this)" data-cell="hine_quantity_2" class="hine_quantity_field text-center @if(isset($hine_details->hine_quantity) && $hine_details->hine_quantity == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_quantity', '1', this)" data-cell="hine_quantity_1" class="hine_quantity_field text-center @if(isset($hine_details->hine_quantity) && $hine_details->hine_quantity == '1') selected-score @endif">
                                <p>Excessive or sluggish</p>
                            </td>
                            <td onclick="updateHINEScore('hine_quantity', '0', this)" data-cell="hine_quantity_0" class="hine_quantity_field text-center @if(isset($hine_details->hine_quantity) && $hine_details->hine_quantity == '0') selected-score @endif">
                                <p>Minimal or none</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_quantity_status = isset($hine_details->hine_quantity_status) ? $hine_details->hine_quantity_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_quantity_status', 1, ($hine_details->hine_quantity_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_quantity_status', 2, ($hine_details->hine_quantity_status == 2 ? true : false)) }} Asymmetric </span><br/>                                
                                {!! Form::textarea('hine_quantity_asymmetric', @$hine_details->hine_quantity_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_quantity_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Quality</strong>
                                <p>Observe infant’s spontaneous voluntary motor activity during the course of the assessment</p>
                                <input type="hidden" name="hine_quality" value="@if(isset($hine_details->hine_quality)) {{ $hine_details->hine_quality }} @endif">
                                <input type="hidden" name="assessment_of_movements[]" id="hine_quality" value="{{@$hine_details->hine_quality}}">
                            </td>
                            <td onclick="updateHINEScore('hine_quality', '3', this)" data-cell="hine_quality_3" class="hine_quality_field text-center @if(isset($hine_details->hine_quality) && $hine_details->hine_quality == '3') selected-score @endif">
                                <p>Free, alternating, and smooth</p>
                            </td>
                            <td onclick="updateHINEScore('hine_quality', '2', this)" data-cell="hine_quality_2" class="hine_quality_field text-center @if(isset($hine_details->hine_quality) && $hine_details->hine_quality == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_quality', '1', this)" data-cell="hine_quality_1" class="hine_quality_field text-center @if(isset($hine_details->hine_quality) && $hine_details->hine_quality == '1') selected-score @endif">
                                <p>Jerky</p>
                                <br>
                                <p>Slight tremor</p>
                            </td>
                            <td onclick="updateHINEScore('hine_quality', '0', this)" data-cell="hine_quality_0" class="hine_quality_field text-center @if(isset($hine_details->hine_quality) && $hine_details->hine_quality == '0') selected-score @endif">
                                <ul class="text-left">
                                    <li>Cramped & synchronous</li>
                                    <li>Extensor spasms</li>
                                    <li>Athetoid</li>
                                    <li>Ataxic</li>
                                    <li>Very tremulous</li>
                                    <li>Myoclonic spasm</li>
                                    <li>Dystonic movement</li>
                                </ul>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_quality_status = isset($hine_details->hine_quality_status) ? $hine_details->hine_quality_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_quality_status', 1, ($hine_details->hine_quality_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_quality_status', 2, ($hine_details->hine_quality_status == 2 ? true : false)) }} Asymmetric </span><br/>                                                            
                                {!! Form::textarea('hine_quality_asymmetric', @$hine_details->hine_quality_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_quality_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hinescreening4">
        <div class="row hine-container mt-10">
            <h3><strong>ASSESSMENT OF TONE</strong></h3>
            <div class="table-responsive">
                <table class="table valign-middle">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Score 3</th>
                            <th>2</th>
                            <th>Score 1</th>
                            <th>Score 0</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Scarf sign</strong>
                                <p>Take the infant’s hand and pull the arm across the chest until there is resistance. Note the position of the elbow in relation to the midline.</p>
                                <input type="hidden" name="hine_scraf_sign" value="@if(isset($hine_details->hine_scraf_sign)) {{ $hine_details->hine_scraf_sign }} @endif">
                                <input type="hidden" name="assessment_of_tone[]" id="hine_scraf_sign" value="{{@$hine_details->hine_scraf_sign}}">
                            </td>
                            <td onclick="updateHINEScore('hine_scraf_sign', '3', this)" data-cell="hine_scraf_sign_3" class="hine_scraf_sign_field text-center @if(isset($hine_details->hine_scraf_sign) && $hine_details->hine_scraf_sign == '3') selected-score @endif">
                                <p><strong>Range:</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/scarf-1.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_scraf_sign', '2', this)" data-cell="hine_scraf_sign_2" class="hine_scraf_sign_field text-center @if(isset($hine_details->hine_scraf_sign) && $hine_details->hine_scraf_sign == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_scraf_sign', '1', this)" data-cell="hine_scraf_sign_1" class="hine_scraf_sign_field text-center @if(isset($hine_details->hine_scraf_sign) && $hine_details->hine_scraf_sign == '1') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/scarf-3.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_scraf_sign', '0', this)" data-cell="hine_scraf_sign_0" class="hine_scraf_sign_field text-center @if(isset($hine_details->hine_scraf_sign) && $hine_details->hine_scraf_sign == '0') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/scarf-4.svg" class="img" />
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_scraf_sign_status = isset($hine_details->hine_scraf_sign_status) ? $hine_details->hine_scraf_sign_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_scraf_sign_status', 1, ($hine_details->hine_scraf_sign_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_scraf_sign_status', 2, ($hine_details->hine_scraf_sign_status == 2 ? true : false)) }} Asymmetric </span><br/>                            
                                {!! Form::textarea('hine_scraf_sign_asymmetric', @$hine_details->hine_scraf_sign_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_scraf_sign_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Passive shoulder elevation</strong>
                                <p>Lift arm up alongside infant’s head. Note resistance at shoulder and elbow.</p>
                                <input type="hidden" name="hine_shoulder_elevation" value="@if(isset($hine_details->hine_shoulder_elevation)) {{ $hine_details->hine_shoulder_elevation }} @endif">
                                <input type="hidden" name="assessment_of_tone[]" id="hine_shoulder_elevation" value="{{@$hine_details->hine_shoulder_elevation}}">
                            </td>
                            <td onclick="updateHINEScore('hine_shoulder_elevation', '3', this)" data-cell="hine_shoulder_elevation_3" class="hine_shoulder_elevation_field text-center @if(isset($hine_details->hine_shoulder_elevation) && $hine_details->hine_shoulder_elevation == '3') selected-score @endif">
                                <p>Resistance overcomeable</p>
                                <img src="{{ url('/') }}/public/img/hine/shoulder-elevation-1.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_shoulder_elevation', '2', this)" data-cell="hine_shoulder_elevation_2" class="hine_shoulder_elevation_field text-center @if(isset($hine_details->hine_shoulder_elevation) && $hine_details->hine_shoulder_elevation == '2') selected-score @endif">
                                <p>Resistance difficult to overcome <br><br><span>R&ensp;&ensp;&ensp;&ensp;&ensp;L</span></p>
                            </td>
                            <td onclick="updateHINEScore('hine_shoulder_elevation', '1', this)" data-cell="hine_shoulder_elevation_1" class="hine_shoulder_elevation_field text-center @if(isset($hine_details->hine_shoulder_elevation) && $hine_details->hine_shoulder_elevation == '1') selected-score @endif">
                                <p>No resistance</p>
                                <img src="{{ url('/') }}/public/img/hine/shoulder-elevation-3.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_shoulder_elevation', '0', this)" data-cell="hine_shoulder_elevation_0" class="hine_shoulder_elevation_field text-center @if(isset($hine_details->hine_shoulder_elevation) && $hine_details->hine_shoulder_elevation == '0') selected-score @endif">
                                <p>Resistance, not overcomeable</p>
                                <img src="{{ url('/') }}/public/img/hine/shoulder-elevation-4.svg" class="img" />
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_shoulder_elevation_status = isset($hine_details->hine_shoulder_elevation_status) ? $hine_details->hine_shoulder_elevation_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_shoulder_elevation_status', 1, ($hine_details->hine_shoulder_elevation_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_shoulder_elevation_status', 2, ($hine_details->hine_shoulder_elevation_status == 2 ? true : false)) }} Asymmetric </span><br/>                                                            
                                {!! Form::textarea('hine_shoulder_elevation_asymmetric', @$hine_details->hine_shoulder_elevation_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_shoulder_elevation_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Pronation/supination</strong>
                                <p>Steady the upper arm while pronating and supinating forearm, note resistance.</p>
                                <input type="hidden" name="hine_pronation_supination" value="@if(isset($hine_details->hine_pronation_supination)) {{ $hine_details->hine_pronation_supination }} @endif">
                                <input type="hidden" name="assessment_of_tone[]" id="hine_pronation_supination" value="{{@$hine_details->hine_pronation_supination}}">
                            </td>
                            <td onclick="updateHINEScore('hine_pronation_supination', '3', this)" data-cell="hine_pronation_supination_3" class="hine_pronation_supination_field text-center @if(isset($hine_details->hine_pronation_supination) && $hine_details->hine_pronation_supination == '3') selected-score @endif">
                                <p>Full pronation and supination, no resistance</p>
                            </td>
                            <td onclick="updateHINEScore('hine_pronation_supination', '2', this)" data-cell="hine_pronation_supination_2" class="hine_pronation_supination_field text-center @if(isset($hine_details->hine_pronation_supination) && $hine_details->hine_pronation_supination == '2') selected-score @endif"></td>
                            <td onclick="updateHINEScore('hine_pronation_supination', '1', this)" data-cell="hine_pronation_supination_1" class="hine_pronation_supination_field text-center @if(isset($hine_details->hine_pronation_supination) && $hine_details->hine_pronation_supination == '1') selected-score @endif">
                                <p>Resistance to full pronation / supination overcomeable</p>
                            </td>
                            <td onclick="updateHINEScore('hine_pronation_supination', '0', this)" data-cell="hine_pronation_supination_0" class="hine_pronation_supination_field text-center @if(isset($hine_details->hine_pronation_supination) && $hine_details->hine_pronation_supination == '0') selected-score @endif">
                                <p>Full pronation and supination not possible, marked resistance</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_pronation_supination_status = isset($hine_details->hine_pronation_supination_status) ? $hine_details->hine_pronation_supination_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_pronation_supination_status', 1, ($hine_details->hine_pronation_supination_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_pronation_supination_status', 2, ($hine_details->hine_pronation_supination_status == 2 ? true : false)) }} Asymmetric </span><br/>                                                            
                                {!! Form::textarea('hine_pronation_supination_asymmetric', @$hine_details->hine_pronation_supination_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_pronation_supination_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Hip adductors</strong>
                                <p>With both the infant’s legs extended, abduct them as far as possible. The angle formed by the legs is noted.</p>
                                <input type="hidden" name="hine_hip_adductors" value="@if(isset($hine_details->hine_hip_adductors)) {{ $hine_details->hine_hip_adductors }} @endif">
                                <input type="hidden" name="assessment_of_tone[]" id="hine_hip_adductors" value="{{@$hine_details->hine_hip_adductors}}">
                            </td>
                            <td onclick="updateHINEScore('hine_hip_adductors', '3', this)" data-cell="hine_hip_adductors_3" class="hine_hip_adductors_field text-center @if(isset($hine_details->hine_hip_adductors) && $hine_details->hine_hip_adductors == '3') selected-score @endif">
                                <p><strong>Range: 150-80°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/hip-adductors-1.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_hip_adductors', '2', this)" data-cell="hine_hip_adductors_2" class="hine_hip_adductors_field text-center @if(isset($hine_details->hine_hip_adductors) && $hine_details->hine_hip_adductors == '2') selected-score @endif">
                                <p><strong>150-160°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/hip-adductors-2.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_hip_adductors', '1', this)" data-cell="hine_hip_adductors_1" class="hine_hip_adductors_field text-center @if(isset($hine_details->hine_hip_adductors) && $hine_details->hine_hip_adductors == '1') selected-score @endif">
                                <p><strong> >170°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/hip-adductors-3.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_hip_adductors', '0', this)" data-cell="hine_hip_adductors_0" class="hine_hip_adductors_field text-center @if(isset($hine_details->hine_hip_adductors) && $hine_details->hine_hip_adductors == '0') selected-score @endif">
                                <p><strong> <80°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/hip-adductors-4.svg" class="img" />
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_hip_adductors_status = isset($hine_details->hine_hip_adductors_status) ? $hine_details->hine_hip_adductors_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_hip_adductors_status', 1, ($hine_details->hine_hip_adductors_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_hip_adductors_status', 2, ($hine_details->hine_hip_adductors_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_hip_adductors_asymmetric', @$hine_details->hine_hip_adductors_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_hip_adductors_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Popliteal angle</strong>
                                <p>Keeping the infant’s bottom on the bed, flex both hips onto the abdomen, then extend the knees until there is resistance. Note the angle between upper and lower leg.</p>
                                <input type="hidden" name="hine_popliteal_angle" value="@if(isset($hine_details->hine_popliteal_angle)) {{ $hine_details->hine_popliteal_angle }} @endif">
                                <input type="hidden" name="assessment_of_tone[]" id="hine_popliteal_angle" value="{{@$hine_details->hine_popliteal_angle}}">
                            </td>
                            <td onclick="updateHINEScore('hine_popliteal_angle', '3', this)" data-cell="hine_popliteal_angle_3" class="hine_popliteal_angle_field text-center @if(isset($hine_details->hine_popliteal_angle) && $hine_details->hine_popliteal_angle == '3') selected-score @endif">
                                <p><strong>Range: 150°-100°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/popliteal-angle-1.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_popliteal_angle', '2', this)" data-cell="hine_popliteal_angle_2" class="hine_popliteal_angle_field text-center @if(isset($hine_details->hine_popliteal_angle) && $hine_details->hine_popliteal_angle == '2') selected-score @endif">
                                <p><strong>150-160°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/popliteal-angle-2.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_popliteal_angle', '1', this)" data-cell="hine_popliteal_angle_1" class="hine_popliteal_angle_field text-center @if(isset($hine_details->hine_popliteal_angle) && $hine_details->hine_popliteal_angle == '1') selected-score @endif">
                                <p><strong> ~90° or > 170°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/popliteal-angle-3.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_popliteal_angle', '0', this)" data-cell="hine_popliteal_angle_0" class="hine_popliteal_angle_field text-center @if(isset($hine_details->hine_popliteal_angle) && $hine_details->hine_popliteal_angle == '0') selected-score @endif">
                                <p><strong> <80°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/popliteal-angle-4.svg" class="img" />
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_popliteal_angle_status = isset($hine_details->hine_popliteal_angle_status) ? $hine_details->hine_popliteal_angle_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_popliteal_angle_status', 1, ($hine_details->hine_popliteal_angle_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_popliteal_angle_status', 2, ($hine_details->hine_popliteal_angle_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_popliteal_angle_asymmetric', @$hine_details->hine_popliteal_angle_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_popliteal_angle_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Ankle dorsiflexion</strong>
                                <p>With knee extended, dorsiflex the ankle. Note the angle between foot and leg.</p>
                                <input type="hidden" name="hine_ankle_dorsiflexion" value="@if(isset($hine_details->hine_ankle_dorsiflexion)) {{ $hine_details->hine_ankle_dorsiflexion }} @endif">
                                <input type="hidden" name="assessment_of_tone[]" id="hine_ankle_dorsiflexion" value="{{@$hine_details->hine_ankle_dorsiflexion}}">
                            </td>
                            <td onclick="updateHINEScore('hine_ankle_dorsiflexion', '3', this)" data-cell="hine_ankle_dorsiflexion_3" class="hine_ankle_dorsiflexion_field text-center @if(isset($hine_details->hine_ankle_dorsiflexion) && $hine_details->hine_ankle_dorsiflexion == '3') selected-score @endif">
                                <p><strong>Range: 30°-85°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/ankle-1.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_ankle_dorsiflexion', '2', this)" data-cell="hine_ankle_dorsiflexion_2" class="hine_ankle_dorsiflexion_field text-center @if(isset($hine_details->hine_ankle_dorsiflexion) && $hine_details->hine_ankle_dorsiflexion == '2') selected-score @endif">
                                <p><strong>20-30°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/ankle-2.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_ankle_dorsiflexion', '1', this)" data-cell="hine_ankle_dorsiflexion_1" class="hine_ankle_dorsiflexion_field text-center @if(isset($hine_details->hine_ankle_dorsiflexion) && $hine_details->hine_ankle_dorsiflexion == '1') selected-score @endif">
                                <p><strong> <20°or 90°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/ankle-3.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_ankle_dorsiflexion', '0', this)" data-cell="hine_ankle_dorsiflexion_0" class="hine_ankle_dorsiflexion_field text-center @if(isset($hine_details->hine_ankle_dorsiflexion) && $hine_details->hine_ankle_dorsiflexion == '0') selected-score @endif">
                                <p><strong> > 90°</strong></p>
                                <img src="{{ url('/') }}/public/img/hine/ankle-4.svg" class="img" />
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_ankle_dorsiflexion_status = isset($hine_details->hine_ankle_dorsiflexion_status) ? $hine_details->hine_ankle_dorsiflexion_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_ankle_dorsiflexion_status', 1, ($hine_details->hine_ankle_dorsiflexion_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_ankle_dorsiflexion_status', 2, ($hine_details->hine_ankle_dorsiflexion_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_ankle_dorsiflexion_asymmetric', @$hine_details->hine_ankle_dorsiflexion_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_ankle_dorsiflexion_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Pull to sit</strong>
                                <p>Pull infant to sit by the wrists. (support head if necessary)</p>
                                <input type="hidden" name="hine_pull_to_sit" value="@if(isset($hine_details->hine_pull_to_sit)) {{ $hine_details->hine_pull_to_sit }} @endif">
                                <input type="hidden" name="assessment_of_tone[]" id="hine_pull_to_sit" value="{{@$hine_details->hine_pull_to_sit}}">
                            </td>
                            <td onclick="updateHINEScore('hine_pull_to_sit', '3', this)" data-cell="hine_pull_to_sit_3" class="hine_pull_to_sit_field text-center @if(isset($hine_details->hine_pull_to_sit) && $hine_details->hine_pull_to_sit == '3') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/pull-to-sit-1.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_pull_to_sit', '2', this)" data-cell="hine_pull_to_sit_2" class="hine_pull_to_sit_field text-center @if(isset($hine_details->hine_pull_to_sit) && $hine_details->hine_pull_to_sit == '2') selected-score @endif"></td>
                            <td onclick="updateHINEScore('hine_pull_to_sit', '1', this)" data-cell="hine_pull_to_sit_1" class="hine_pull_to_sit_field text-center @if(isset($hine_details->hine_pull_to_sit) && $hine_details->hine_pull_to_sit == '1') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/pull-to-sit-3.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_pull_to_sit', '0', this)" data-cell="hine_pull_to_sit_0" class="hine_pull_to_sit_field text-center @if(isset($hine_details->hine_pull_to_sit) && $hine_details->hine_pull_to_sit == '0') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/pull-to-sit-4.svg" class="img" />
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_pull_to_sit_status = isset($hine_details->hine_pull_to_sit_status) ? $hine_details->hine_pull_to_sit_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_pull_to_sit_status', 1, ($hine_details->hine_pull_to_sit_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_pull_to_sit_status', 2, ($hine_details->hine_pull_to_sit_status == 2 ? true : false)) }} Asymmetric </span><br/>                                
                                {!! Form::textarea('hine_pull_to_sit_asymmetric', @$hine_details->hine_pull_to_sit_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_pull_to_sit_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Ventral suspension</strong>
                                <p>Hold infant horizontally around trunk in ventral suspension; note position of back, limbs and head.</p>
                                <input type="hidden" name="hine_ventral_suspension" value="@if(isset($hine_details->hine_ventral_suspension)) {{ $hine_details->hine_ventral_suspension }} @endif">
                                <input type="hidden" name="assessment_of_tone[]" id="hine_ventral_suspension" value="{{@$hine_details->hine_ventral_suspension}}">
                            </td>
                            <td onclick="updateHINEScore('hine_ventral_suspension', '3', this)" data-cell="hine_ventral_suspension_3" class="hine_ventral_suspension_field text-center @if(isset($hine_details->hine_ventral_suspension) && $hine_details->hine_ventral_suspension == '3') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/ventral-suspension-1.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_ventral_suspension', '2', this)" data-cell="hine_ventral_suspension_2" class="hine_ventral_suspension_field text-center @if(isset($hine_details->hine_ventral_suspension) && $hine_details->hine_ventral_suspension == '2') selected-score @endif"></td>
                            <td onclick="updateHINEScore('hine_ventral_suspension', '1', this)" data-cell="hine_ventral_suspension_1" class="hine_ventral_suspension_field text-center @if(isset($hine_details->hine_ventral_suspension) && $hine_details->hine_ventral_suspension == '1') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/ventral-suspension-3.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_ventral_suspension', '0', this)" data-cell="hine_ventral_suspension_0" class="hine_ventral_suspension_field text-center @if(isset($hine_details->hine_ventral_suspension) && $hine_details->hine_ventral_suspension == '0') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/ventral-suspension-4.svg" class="img" />
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_ventral_suspension_status = isset($hine_details->hine_ventral_suspension_status) ? $hine_details->hine_ventral_suspension_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_ventral_suspension_status', 1, ($hine_details->hine_ventral_suspension_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_ventral_suspension_status', 2, ($hine_details->hine_ventral_suspension_status == 2 ? true : false)) }} Asymmetric </span><br/>                                
                                {!! Form::textarea('hine_ventral_suspension_asymmetric', @$hine_details->hine_ventral_suspension_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_ventral_suspension_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hinescreening5">
        <div class="row hine-container mt-10">
            <h3><strong>REFLEXES AND REACTIONS</strong></h3>
            <div class="table-responsive">
                <table class="table valign-middle">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Score 3</th>
                            <th>2</th>
                            <th>Score 1</th>
                            <th>Score 0</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Arm protection</strong>
                                <p>Pull the infant by one arm from the supine position (steady the contralateral hip) and note the reaction of arm on opposite side.</p>
                                <input type="hidden" name="hine_arm_production" value="@if(isset($hine_details->hine_arm_production)) {{ $hine_details->hine_arm_production }} @endif">
                                <input type="hidden" name="reflexes_and_reactions[]" id="hine_arm_production" value="{{@$hine_details->hine_arm_production}}">
                            </td>
                            <td onclick="updateHINEScore('hine_arm_production', '3', this)" data-cell="hine_arm_production_3" class="hine_arm_production_field text-center @if(isset($hine_details->hine_arm_production) && $hine_details->hine_arm_production == '3') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/arm-protection-1.svg" class="img" />
                                <p>Arm & hand extend
                                    <br>
                                    <span>R &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;L</span>
                                </p>
                            </td>
                            <td onclick="updateHINEScore('hine_arm_production', '2', this)" data-cell="hine_arm_production_2" class="hine_arm_production_field text-center @if(isset($hine_details->hine_arm_production) && $hine_details->hine_arm_production == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_arm_production', '1', this)" data-cell="hine_arm_production_1" class="hine_arm_production_field text-center @if(isset($hine_details->hine_arm_production) && $hine_details->hine_arm_production == '1') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/arm-protection-3.svg" class="img" />
                                <p>Arm semi-flexed
                                    <br>
                                    <span>R &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;L</span>
                                </p>
                            </td>
                            <td onclick="updateHINEScore('hine_arm_production', '0', this)" data-cell="hine_arm_production_0" class="hine_arm_production_field text-center @if(isset($hine_details->hine_arm_production) && $hine_details->hine_arm_production == '0') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/arm-protection-4.svg" class="img" />
                                <p>Arm fully flexed
                                    <br>
                                    <span>R &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;L</span>
                                </p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_arm_production_status = isset($hine_details->hine_arm_production_status) ? $hine_details->hine_arm_production_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_arm_production_status', 1, ($hine_details->hine_arm_production_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_arm_production_status', 2, ($hine_details->hine_arm_production_status == 2 ? true : false)) }} Asymmetric </span><br/>                            
                                {!! Form::textarea('hine_arm_production_asymmetric', @$hine_details->hine_arm_production_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_arm_production_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Vertical suspension</strong>
                                <p>hold infant under axilla making sure legs do not touch any surface – you may “tickle” feet to stimulate kicking.</p>
                                <input type="hidden" name="hine_vertical_suspension" value="@if(isset($hine_details->hine_vertical_suspension)) {{ $hine_details->hine_vertical_suspension }} @endif">
                                <input type="hidden" name="reflexes_and_reactions[]" id="hine_vertical_suspension" value="{{@$hine_details->hine_vertical_suspension}}">
                            </td>
                            <td onclick="updateHINEScore('hine_vertical_suspension', '3', this)" data-cell="hine_vertical_suspension_3" class="hine_vertical_suspension_field text-center @if(isset($hine_details->hine_vertical_suspension) && $hine_details->hine_vertical_suspension == '3') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/vertical-suspension-1.svg" class="img" />
                                <p>Kicks symmetrically</p>
                            </td>
                            <td onclick="updateHINEScore('hine_vertical_suspension', '2', this)" data-cell="hine_vertical_suspension_2" class="hine_vertical_suspension_field text-center @if(isset($hine_details->hine_vertical_suspension) && $hine_details->hine_vertical_suspension == '2') selected-score @endif">
                            </td>
                            <td onclick="updateHINEScore('hine_vertical_suspension', '1', this)" data-cell="hine_vertical_suspension_1" class="hine_vertical_suspension_field text-center @if(isset($hine_details->hine_vertical_suspension) && $hine_details->hine_vertical_suspension == '1') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/vertical-suspension-3.svg" class="img" />
                                <p>Kicks one leg more or poor kicking</p>
                            </td>
                            <td onclick="updateHINEScore('hine_vertical_suspension', '0', this)" data-cell="hine_vertical_suspension_0" class="hine_vertical_suspension_field text-center @if(isset($hine_details->hine_vertical_suspension) && $hine_details->hine_vertical_suspension == '0') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/vertical-suspension-4.svg" class="img" />
                                <p>No kicking even if stimulated or scissoring</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_vertical_suspension_status = isset($hine_details->hine_vertical_suspension_status) ? $hine_details->hine_vertical_suspension_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_vertical_suspension_status', 1, ($hine_details->hine_vertical_suspension_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_vertical_suspension_status', 2, ($hine_details->hine_vertical_suspension_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_vertical_suspension_asymmetric', @$hine_details->hine_vertical_suspension_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_vertical_suspension_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Lateral tilting</strong>
                                <p>(describe side up). Hold infant up vertically near to hips and tilt sideways towards the horizontal. Note response of trunk, spine, limbs and head.</p>
                                <input type="hidden" name="hine_lateral_tilting" value="@if(isset($hine_details->hine_lateral_tilting)) {{ $hine_details->hine_lateral_tilting }} @endif">
                                <input type="hidden" name="reflexes_and_reactions[]" id="hine_lateral_tilting" value="{{@$hine_details->hine_lateral_tilting}}">
                            </td>
                            <td onclick="updateHINEScore('hine_lateral_tilting', '3', this)" data-cell="hine_lateral_tilting_3" class="hine_lateral_tilting_field text-center @if(isset($hine_details->hine_lateral_tilting) && $hine_details->hine_lateral_tilting == '3') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/lateral-tilting-1.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_lateral_tilting', '2', this)" data-cell="hine_lateral_tilting_2" class="hine_lateral_tilting_field text-center @if(isset($hine_details->hine_lateral_tilting) && $hine_details->hine_lateral_tilting == '2') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/lateral-tilting-2.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_lateral_tilting', '1', this)" data-cell="hine_lateral_tilting_1" class="hine_lateral_tilting_field text-center @if(isset($hine_details->hine_lateral_tilting) && $hine_details->hine_lateral_tilting == '1') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/lateral-tilting-3.svg" class="img" />
                            </td>
                            <td onclick="updateHINEScore('hine_lateral_tilting', '0', this)" data-cell="hine_lateral_tilting_0" class="hine_lateral_tilting_field text-center @if(isset($hine_details->hine_lateral_tilting) && $hine_details->hine_lateral_tilting == '0') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/lateral-tilting-4.svg" class="img" />
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_lateral_tilting_status = isset($hine_details->hine_lateral_tilting_status) ? $hine_details->hine_lateral_tilting_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_lateral_tilting_status', 1, ($hine_details->hine_lateral_tilting_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_lateral_tilting_status', 2, ($hine_details->hine_lateral_tilting_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_lateral_tilting_asymmetric', @$hine_details->hine_lateral_tilting_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_lateral_tilting_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Forward parachute</strong>
                                <p>Hold infant up vertically and quickly tilt forwards. Note reaction /symmetry of arm responses,</p>
                                <input type="hidden" name="hine_forward_parachute" value="@if(isset($hine_details->hine_forward_parachute)) {{ $hine_details->hine_forward_parachute }} @endif">
                                <input type="hidden" name="reflexes_and_reactions[]" id="hine_forward_parachute" value="{{@$hine_details->hine_forward_parachute}}">
                            </td>
                            <td onclick="updateHINEScore('hine_forward_parachute', '3', this)" data-cell="hine_forward_parachute_3" class="hine_forward_parachute_field text-center @if(isset($hine_details->hine_forward_parachute) && $hine_details->hine_forward_parachute == '3') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/forward-parachute-1.svg" class="img" />
                                <p>(after 6 months)</p>
                            </td>
                            <td onclick="updateHINEScore('hine_forward_parachute', '2', this)" data-cell="hine_forward_parachute_2" class="hine_forward_parachute_field text-center @if(isset($hine_details->hine_forward_parachute) && $hine_details->hine_forward_parachute == '2') selected-score @endif"></td>
                            <td onclick="updateHINEScore('hine_forward_parachute', '1', this)" data-cell="hine_forward_parachute_1" class="hine_forward_parachute_field text-center @if(isset($hine_details->hine_forward_parachute) && $hine_details->hine_forward_parachute == '1') selected-score @endif">
                                <img src="{{ url('/') }}/public/img/hine/forward-parachute-3.svg" class="img" />
                                <p>(after 6 months)</p>
                            </td>
                            <td></td>
                            <td class="vertical-top">
                                @php $hine_details->hine_forward_parachute_status = isset($hine_details->hine_forward_parachute_status) ? $hine_details->hine_forward_parachute_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_forward_parachute_status', 1, ($hine_details->hine_forward_parachute_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_forward_parachute_status', 2, ($hine_details->hine_forward_parachute_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_forward_parachute_asymmetric', @$hine_details->hine_forward_parachute_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_forward_parachute_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="15%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Tendon Reflexes</strong>
                                <p>Have child relaxed, sitting or lying – use small hammer</p>
                                <input type="hidden" name="hine_tendon_reflexes" value="@if(isset($hine_details->hine_tendon_reflexes)) {{ $hine_details->hine_tendon_reflexes }} @endif">
                                <input type="hidden" name="reflexes_and_reactions[]" id="hine_tendon_reflexes" value="{{@$hine_details->hine_tendon_reflexes}}">
                            </td>
                            <td onclick="updateHINEScore('hine_tendon_reflexes', '3', this)" data-cell="hine_tendon_reflexes_3" class="hine_tendon_reflexes_field text-center @if(isset($hine_details->hine_tendon_reflexes) && $hine_details->hine_tendon_reflexes == '3') selected-score @endif">
                                <p>Easily elicitable biceps knee ankle</p>
                            </td>
                            <td onclick="updateHINEScore('hine_tendon_reflexes', '2', this)" data-cell="hine_tendon_reflexes_2" class="hine_tendon_reflexes_field text-center @if(isset($hine_details->hine_tendon_reflexes) && $hine_details->hine_tendon_reflexes == '2') selected-score @endif">
                                <p>Mildly brisk bicep knee ankle</p>
                            </td>
                            <td onclick="updateHINEScore('hine_tendon_reflexes', '1', this)" data-cell="hine_tendon_reflexes_1" class="hine_tendon_reflexes_field text-center @if(isset($hine_details->hine_tendon_reflexes) && $hine_details->hine_tendon_reflexes == '1') selected-score @endif">
                                <p>Brisk biceps knee ankle</p>
                            </td>
                            <td onclick="updateHINEScore('hine_tendon_reflexes', '0', this)" data-cell="hine_tendon_reflexes_0" class="hine_tendon_reflexes_field text-center @if(isset($hine_details->hine_tendon_reflexes) && $hine_details->hine_tendon_reflexes == '0') selected-score @endif">
                                <p>Clonus or absent biceps knee ankle</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_tendon_reflexes_status = isset($hine_details->hine_tendon_reflexes_status) ? $hine_details->hine_tendon_reflexes_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_tendon_reflexes_status', 1, ($hine_details->hine_tendon_reflexes_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_tendon_reflexes_status', 2, ($hine_details->hine_tendon_reflexes_status == 2 ? true : false)) }} Asymmetric </span><br/>                                
                                {!! Form::textarea('hine_tendon_reflexes_asymmetric', @$hine_details->hine_tendon_reflexes_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_tendon_reflexes_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hinescreening6">
        <div class="row hine-container exception-container mt-10">
            <h3><strong>SECTION 2 MOTOR MILESTONES (not scored; note asymmetries)</strong></h3>
            <div class="table-responsive">
                <table class="table valign-middle">
                    <tbody>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Head control</strong>
                                <input type="hidden" name="hine_head_control" value="@if(isset($hine_details->hine_head_control)) {{ $hine_details->hine_head_control }} @endif">
                                <input type="hidden" name="section_2_motor_milestones[]" id="hine_head_control" value="{{@$hine_details->hine_head_control}}">
                            </td>
                            <td onclick="updateHINEScore('hine_head_control', '5', this)" data-cell="hine_head_control_5" class="hine_head_control_field text-center @if(isset($hine_details->hine_head_control) && $hine_details->hine_head_control == '5') selected-score @endif">
                                <p>Unable to maintain head upright <br> normal to 3m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_head_control', '4', this)" data-cell="hine_head_control_4" class="hine_head_control_field text-center @if(isset($hine_details->hine_head_control) && $hine_details->hine_head_control == '4') selected-score @endif">
                                <p>Wobbles <br> normal up to 3m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_head_control', '3', this)" data-cell="hine_head_control_3" class="hine_head_control_field text-center @if(isset($hine_details->hine_head_control) && $hine_details->hine_head_control == '3') selected-score @endif">
                                <p>Maintained upright all the time <br> normal from 5m</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td class="vertical-top">
                                @php $hine_details->hine_head_control_status = isset($hine_details->hine_head_control_status) ? $hine_details->hine_head_control_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_head_control_status', 1, ($hine_details->hine_head_control_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_head_control_status', 2, ($hine_details->hine_head_control_status == 2 ? true : false)) }} Asymmetric </span><br/>                                                                
                                {!! Form::textarea('hine_head_control_asymmetric', @$hine_details->hine_head_control_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_head_control_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Sitting</strong>
                                <input type="hidden" name="hine_sitting" value="@if(isset($hine_details->hine_sitting)) {{ $hine_details->hine_sitting }} @endif">
                                <input type="hidden" name="section_2_motor_milestones[]" id="hine_sitting" value="{{@$hine_details->hine_sitting}}">
                            </td>
                            <td onclick="updateHINEScore('hine_sitting', '5', this)" data-cell="hine_sitting_5" class="hine_sitting_field text-center @if(isset($hine_details->hine_sitting) && $hine_details->hine_sitting == '5') selected-score @endif">
                                <p>Cannot sit</p>
                            </td>
                            <td onclick="updateHINEScore('hine_sitting', '4', this)" data-cell="hine_sitting_4" class="hine_sitting_field text-center @if(isset($hine_details->hine_sitting) && $hine_details->hine_sitting == '4') selected-score @endif">
                                <p>With support at hips</p>
                                <img src="{{ url('/') }}/public/img/hine/sitting-2.svg" class="img" />
                                <p>normal at 4m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_sitting', '3', this)" data-cell="hine_sitting_3" class="hine_sitting_field text-center @if(isset($hine_details->hine_sitting) && $hine_details->hine_sitting == '3') selected-score @endif">
                                <p>Props</p>
                                <img src="{{ url('/') }}/public/img/hine/sitting-3.svg" class="img" />
                                <p>normal at 6m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_sitting', '2', this)" data-cell="hine_sitting_2" class="hine_sitting_field text-center @if(isset($hine_details->hine_sitting) && $hine_details->hine_sitting == '2') selected-score @endif">
                                <p>Stable sit</p>
                                <img src="{{ url('/') }}/public/img/hine/sitting-4.svg" class="img" />
                                <p>normal at 7-8m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_sitting', '1', this)" data-cell="hine_sitting_1" class="hine_sitting_field text-center @if(isset($hine_details->hine_sitting) && $hine_details->hine_sitting == '1') selected-score @endif">
                                <p>Pivots (rotates)</p>
                                <img src="{{ url('/') }}/public/img/hine/sitting-5.svg" class="img" />
                                <p>normal at 9m</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_sitting_status = isset($hine_details->hine_sitting_status) ? $hine_details->hine_sitting_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_sitting_status', 1, ($hine_details->hine_sitting_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_sitting_status', 2, ($hine_details->hine_sitting_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_sitting_asymmetric', @$hine_details->hine_sitting_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_sitting_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Voluntary grasp – note side</strong>
                                <input type="hidden" name="hine_voluntary_grasp" value="@if(isset($hine_details->hine_voluntary_grasp)) {{ $hine_details->hine_voluntary_grasp }} @endif">
                                <input type="hidden" name="section_2_motor_milestones[]" id="hine_voluntary_grasp" value="{{@$hine_details->hine_voluntary_grasp}}">
                            </td>
                            <td onclick="updateHINEScore('hine_voluntary_grasp', '5', this)" data-cell="hine_voluntary_grasp_5" class="hine_voluntary_grasp_field text-center @if(isset($hine_details->hine_voluntary_grasp) && $hine_details->hine_voluntary_grasp == '5') selected-score @endif">
                                <p>No grasp</p>
                            </td>
                            <td onclick="updateHINEScore('hine_voluntary_grasp', '4', this)" data-cell="hine_voluntary_grasp_4" class="hine_voluntary_grasp_field text-center @if(isset($hine_details->hine_voluntary_grasp) && $hine_details->hine_voluntary_grasp == '4') selected-score @endif">
                                <p>Uses whole hand</p>
                            </td>
                            <td onclick="updateHINEScore('hine_voluntary_grasp', '3', this)" data-cell="hine_voluntary_grasp_3" class="hine_voluntary_grasp_field text-center @if(isset($hine_details->hine_voluntary_grasp) && $hine_details->hine_voluntary_grasp == '3') selected-score @endif">
                                <p>Index finger and thumb but immature grasp</p>
                            </td>
                            <td onclick="updateHINEScore('hine_voluntary_grasp', '2', this)" data-cell="hine_voluntary_grasp_2" class="hine_voluntary_grasp_field text-center @if(isset($hine_details->hine_voluntary_grasp) && $hine_details->hine_voluntary_grasp == '2') selected-score @endif">
                                <p>Pincer grasp</p>
                            </td>
                            <td></td>
                            <td class="vertical-top">
                                @php $hine_details->hine_voluntary_grasp_status = isset($hine_details->hine_voluntary_grasp_status) ? $hine_details->hine_voluntary_grasp_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_voluntary_grasp_status', 1, ($hine_details->hine_voluntary_grasp_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_voluntary_grasp_status', 2, ($hine_details->hine_voluntary_grasp_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_voluntary_grasp_asymmetric', @$hine_details->hine_voluntary_grasp_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_voluntary_grasp_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Ability to kick in supine</strong>
                                <input type="hidden" name="hine_ability_to_kick" value="@if(isset($hine_details->hine_ability_to_kick)) {{ $hine_details->hine_ability_to_kick }} @endif">
                                <input type="hidden" name="section_2_motor_milestones[]" id="hine_ability_to_kick" value="{{@$hine_details->hine_ability_to_kick}}">
                            </td>
                            <td onclick="updateHINEScore('hine_ability_to_kick', '5', this)" data-cell="hine_ability_to_kick_5" class="hine_ability_to_kick_field text-center @if(isset($hine_details->hine_ability_to_kick) && $hine_details->hine_ability_to_kick == '5') selected-score @endif">
                                <p>No kicking</p>
                            </td>
                            <td onclick="updateHINEScore('hine_ability_to_kick', '4', this)" data-cell="hine_ability_to_kick_4" class="hine_ability_to_kick_field text-center @if(isset($hine_details->hine_ability_to_kick) && $hine_details->hine_ability_to_kick == '4') selected-score @endif">
                                <p>Kicks horizontally but legs do not lift</p>
                            </td>
                            <td onclick="updateHINEScore('hine_ability_to_kick', '3', this)" data-cell="hine_ability_to_kick_3" class="hine_ability_to_kick_field text-center @if(isset($hine_details->hine_ability_to_kick) && $hine_details->hine_ability_to_kick == '3') selected-score @endif">
                                <p>Upward (vertically)</p>
                                <img src="{{ url('/') }}/public/img/hine/kick-3.svg" class="img" />
                                <p>normal at 3m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_ability_to_kick', '2', this)" data-cell="hine_ability_to_kick_2" class="hine_ability_to_kick_field text-center @if(isset($hine_details->hine_ability_to_kick) && $hine_details->hine_ability_to_kick == '2') selected-score @endif">
                                <p>Touches leg</p>
                                <img src="{{ url('/') }}/public/img/hine/kick-4.svg" class="img" />
                                <p>normal at 4-5m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_ability_to_kick', '1', this)" data-cell="hine_ability_to_kick_1" class="hine_ability_to_kick_field text-center @if(isset($hine_details->hine_ability_to_kick) && $hine_details->hine_ability_to_kick == '1') selected-score @endif">
                                <p>Touches toes</p>
                                <img src="{{ url('/') }}/public/img/hine/kick-5.svg" class="img" />
                                <p>normal at 5-6m</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_ability_to_kick_status = isset($hine_details->hine_ability_to_kick_status) ? $hine_details->hine_ability_to_kick_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_ability_to_kick_status', 1, ($hine_details->hine_ability_to_kick_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_ability_to_kick_status', 2, ($hine_details->hine_ability_to_kick_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_ability_to_kick_asymmetric', @$hine_details->hine_ability_to_kick_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_ability_to_kick_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Rolling - note through which side(s)</strong>
                                <input type="hidden" name="hine_rolling" value="@if(isset($hine_details->hine_rolling)) {{ $hine_details->hine_rolling }} @endif">
                                <input type="hidden" name="section_2_motor_milestones[]" id="hine_rolling" value="{{@$hine_details->hine_rolling}}">
                            </td>
                            <td onclick="updateHINEScore('hine_rolling', '5', this)" data-cell="hine_rolling_5" class="hine_rolling_field text-center @if(isset($hine_details->hine_rolling) && $hine_details->hine_rolling == '5') selected-score @endif">
                                <p>No rolling</p>
                            </td>
                            <td onclick="updateHINEScore('hine_rolling', '4', this)" data-cell="hine_rolling_4" class="hine_rolling_field text-center @if(isset($hine_details->hine_rolling) && $hine_details->hine_rolling == '4') selected-score @endif">
                                <p>Rolling to side</p>
                                <p>normal at 4m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_rolling', '3', this)" data-cell="hine_rolling_3" class="hine_rolling_field text-center @if(isset($hine_details->hine_rolling) && $hine_details->hine_rolling == '3') selected-score @endif">
                                <p>Prone to supine</p>
                                <p>normal at 3m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_rolling', '2', this)" data-cell="hine_rolling_2" class="hine_rolling_field text-center @if(isset($hine_details->hine_rolling) && $hine_details->hine_rolling == '2') selected-score @endif">
                                <p>Supine to prone</p>
                                <p>normal at 6m</p>
                            </td>
                            <td></td>
                            <td class="vertical-top">
                                @php $hine_details->hine_rolling_status = isset($hine_details->hine_rolling_status) ? $hine_details->hine_rolling_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_rolling_status', 1, ($hine_details->hine_rolling_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_rolling_status', 2, ($hine_details->hine_rolling_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_rolling_asymmetric', @$hine_details->hine_rolling_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_rolling_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Crawling</strong>
                                <input type="hidden" name="hine_crawling" value="@if(isset($hine_details->hine_crawling)) {{ $hine_details->hine_crawling }} @endif">
                                <input type="hidden" name="section_2_motor_milestones[]" id="hine_crawling" value="{{@$hine_details->hine_crawling}}">
                            </td>
                            <td onclick="updateHINEScore('hine_crawling', '5', this)" data-cell="hine_crawling_5" class="hine_crawling_field text-center @if(isset($hine_details->hine_crawling) && $hine_details->hine_crawling == '5') selected-score @endif">
                                <p>No rolling</p>
                            </td>
                            <td onclick="updateHINEScore('hine_crawling', '4', this)" data-cell="hine_crawling_4" class="hine_crawling_field text-center @if(isset($hine_details->hine_crawling) && $hine_details->hine_crawling == '4') selected-score @endif">
                                <p>On elbows</p>
                                <img src="{{ url('/') }}/public/img/hine/crawling-4.svg" class="img" />
                                <p>normal at 3m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_crawling', '3', this)" data-cell="hine_crawling_3" class="hine_crawling_field text-center @if(isset($hine_details->hine_crawling) && $hine_details->hine_crawling == '3') selected-score @endif">
                                <p>On outstretched hands</p>
                                <img src="{{ url('/') }}/public/img/hine/crawling-4.svg" class="img" />
                                <p>normal at 4m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_crawling', '2', this)" data-cell="hine_crawling_2" class="hine_crawling_field text-center @if(isset($hine_details->hine_crawling) && $hine_details->hine_crawling == '2') selected-score @endif">
                                <p>Crawling flat on abdomen</p>
                                <img src="{{ url('/') }}/public/img/hine/crawling-4.svg" class="img" />
                                <p>normal at 8m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_crawling', '1', this)" data-cell="hine_crawling_1" class="hine_crawling_field text-center @if(isset($hine_details->hine_crawling) && $hine_details->hine_crawling == '1') selected-score @endif">
                                <p>Crawling on hands and knees</p>
                                <img src="{{ url('/') }}/public/img/hine/crawling-4.svg" class="img" />
                                <p>normal at 10m</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_crawling_status = isset($hine_details->hine_crawling_status) ? $hine_details->hine_crawling_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_crawling_status', 1, ($hine_details->hine_crawling_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_crawling_status', 2, ($hine_details->hine_crawling_status == 2 ? true : false)) }} Asymmetric </span><br/>                            
                                {!! Form::textarea('hine_crawling_asymmetric', @$hine_details->hine_crawling_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_crawling_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Standing</strong>
                                <input type="hidden" name="hine_standing" value="@if(isset($hine_details->hine_standing)) {{ $hine_details->hine_standing }} @endif">
                                <input type="hidden" name="section_2_motor_milestones[]" id="hine_standing" value="{{@$hine_details->hine_standing}}">
                            </td>
                            <td onclick="updateHINEScore('hine_standing', '5', this)" data-cell="hine_standing_5" class="hine_standing_field text-center @if(isset($hine_details->hine_standing) && $hine_details->hine_standing == '5') selected-score @endif">
                                <p>Does not support weight</p>
                            </td>
                            <td onclick="updateHINEScore('hine_standing', '4', this)" data-cell="hine_standing_4" class="hine_standing_field text-center @if(isset($hine_details->hine_standing) && $hine_details->hine_standing == '4') selected-score @endif">
                                <p>Supports weight</p>
                                <p>normal at 4m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_standing', '3', this)" data-cell="hine_standing_3" class="hine_standing_field text-center @if(isset($hine_details->hine_standing) && $hine_details->hine_standing == '3') selected-score @endif">
                                <p>Stands with support</p>
                                <p>normal at 7m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_standing', '2', this)" data-cell="hine_standing_2" class="hine_standing_field text-center @if(isset($hine_details->hine_standing) && $hine_details->hine_standing == '2') selected-score @endif">
                                <p>Stands unaided</p>
                                <p>normal at 12m</p>
                            </td>
                            <td></td>
                            <td class="vertical-top">
                                @php $hine_details->hine_standing_status = isset($hine_details->hine_standing_status) ? $hine_details->hine_standing_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_standing_status', 1, ($hine_details->hine_standing_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_standing_status', 2, ($hine_details->hine_standing_status == 2 ? true : false)) }} Asymmetric </span><br/>                                                            
                                {!! Form::textarea('hine_standing_asymmetric', @$hine_details->hine_standing_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_standing_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Walking</strong>
                                <input type="hidden" name="hine_walking" value="@if(isset($hine_details->hine_walking)) {{ $hine_details->hine_walking }} @endif">
                                <input type="hidden" name="section_2_motor_milestones[]" id="hine_walking" value="{{@$hine_details->hine_walking}}">
                            </td>
                            <td></td>
                            <td onclick="updateHINEScore('hine_walking', '4', this)" data-cell="hine_walking_4" class="hine_walking_field text-center @if(isset($hine_details->hine_walking) && $hine_details->hine_walking == '4') selected-score @endif">
                                <p>Bouncing</p>
                                <p>normal at 6m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_walking', '3', this)" data-cell="hine_walking_3" class="hine_walking_field text-center @if(isset($hine_details->hine_walking) && $hine_details->hine_walking == '3') selected-score @endif">
                                <p>Cruising (walks holding on)</p>
                                <p>normal at 12m</p>
                            </td>
                            <td onclick="updateHINEScore('hine_walking', '2', this)" data-cell="hine_walking_2" class="hine_walking_field text-center @if(isset($hine_details->hine_walking) && $hine_details->hine_walking == '2') selected-score @endif">
                                <p>Walking independently</p>
                                <p>normal at 15m</p>
                            </td>
                            <td></td>
                            <td class="vertical-top">
                                @php $hine_details->hine_walking_status = isset($hine_details->hine_walking_status) ? $hine_details->hine_walking_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_walking_status', 1, ($hine_details->hine_walking_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_walking_status', 2, ($hine_details->hine_walking_status == 2 ? true : false)) }} Asymmetric </span><br/>                                                                                        
                                {!! Form::textarea('hine_walking_asymmetric', @$hine_details->hine_walking_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_walking_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hinescreening7">
        <div class="row hine-container exception-container mt-10">
            <h3><strong>BEHAVIOUR (not scored)</strong></h3>
            <div class="table-responsive">
                <table class="table valign-middle">
                    <thead>
                        <tr>
                            <th></th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Conscious state</strong>
                                <input type="hidden" name="hine_conscious_state" value="@if(isset($hine_details->hine_conscious_state)) {{ $hine_details->hine_conscious_state }} @endif">
                                <input type="hidden" name="behaviour[]" id="hine_conscious_state" value="{{@$hine_details->hine_conscious_state}}">
                            </td>
                            <td onclick="updateHINEScore('hine_conscious_state', '5', this)" data-cell="hine_conscious_state_5" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '5') selected-score @endif">
                                <p>Unrousable</p>
                            </td>
                            <td onclick="updateHINEScore('hine_conscious_state', '4', this)" data-cell="hine_conscious_state_4" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '4') selected-score @endif">
                                <p>Drowsy</p>
                            </td>
                            <td onclick="updateHINEScore('hine_conscious_state', '3', this)" data-cell="hine_conscious_state_3" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '3') selected-score @endif">
                                <p>Sleep but wakes easily</p>
                            </td>
                            <td onclick="updateHINEScore('hine_conscious_state', '2', this)" data-cell="hine_conscious_state_2" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '2') selected-score @endif">
                                <p>Awake but no interest</p>
                            </td>
                            <td onclick="updateHINEScore('hine_conscious_state', '1', this)" data-cell="hine_conscious_state_1" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '1') selected-score @endif">
                                <p>Loses interest</p>
                            </td>
                            <td onclick="updateHINEScore('hine_conscious_state', '0', this)" data-cell="hine_conscious_state_0" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '0') selected-score @endif">
                                <p>Maintains interest</p>
                            </td>
                            <td class="vertical-top">
                                @php $hine_details->hine_conscious_state_status = isset($hine_details->hine_conscious_state_status) ? $hine_details->hine_conscious_state_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_conscious_state_status', 1, ($hine_details->hine_conscious_state_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_conscious_state_status', 2, ($hine_details->hine_conscious_state_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_conscious_state_asymmetric', @$hine_details->hine_conscious_state_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_conscious_state_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Emotional state</strong>
                                <input type="hidden" name="hine_emotional_state" value="@if(isset($hine_details->hine_emotional_state)) {{ $hine_details->hine_emotional_state }} @endif">
                                <input type="hidden" name="behaviour[]" id="hine_emotional_state" value="{{@$hine_details->hine_emotional_state}}">
                            </td>
                            <td onclick="updateHINEScore('hine_emotional_state', '5', this)" data-cell="hine_emotional_state_5" class="hine_emotional_state_field text-center @if(isset($hine_details->hine_emotional_state) && $hine_details->hine_emotional_state == '5') selected-score @endif">
                                <p>Irritable, not consolable</p>
                            </td>
                            <td onclick="updateHINEScore('hine_emotional_state', '4', this)" data-cell="hine_emotional_state_4" class="hine_emotional_state_field text-center @if(isset($hine_details->hine_emotional_state) && $hine_details->hine_emotional_state == '4') selected-score @endif">
                                <p>Irritable, carer can console</p>
                            </td>
                            <td onclick="updateHINEScore('hine_emotional_state', '3', this)" data-cell="hine_emotional_state_3" class="hine_emotional_state_field text-center @if(isset($hine_details->hine_emotional_state) && $hine_details->hine_emotional_state == '3') selected-score @endif">
                                <p>Irritable when approached</p>
                            </td>
                            <td onclick="updateHINEScore('hine_emotional_state', '2', this)" data-cell="hine_emotional_state_2" class="hine_emotional_state_field text-center @if(isset($hine_details->hine_emotional_state) && $hine_details->hine_emotional_state == '2') selected-score @endif">
                                <p>Neither happy or unhappy</p>
                            </td>
                            <td onclick="updateHINEScore('hine_emotional_state', '1', this)" data-cell="hine_emotional_state_1" class="hine_emotional_state_field text-center @if(isset($hine_details->hine_emotional_state) && $hine_details->hine_emotional_state == '1') selected-score @endif">
                                <p>Happy and smiling</p>
                            </td>
                            <td></td>
                            <td class="vertical-top">
                                @php $hine_details->hine_emotional_state_status = isset($hine_details->hine_emotional_state_status) ? $hine_details->hine_emotional_state_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_emotional_state_status', 1, ($hine_details->hine_emotional_state_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_emotional_state_status', 2, ($hine_details->hine_emotional_state_status == 2 ? true : false)) }} Asymmetric </span><br/>                                
                                {!! Form::textarea('hine_emotional_state_asymmetric', @$hine_details->hine_emotional_state_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_emotional_state_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="row-head" width="5%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>Social orientation</strong>
                                <input type="hidden" name="hine_social_orientation" value="@if(isset($hine_details->hine_social_orientation)) {{ $hine_details->hine_social_orientation }} @endif">
                                <input type="hidden" name="behaviour[]" id="hine_social_orientation" value="{{@$hine_details->hine_social_orientation}}">
                            </td>
                            <td onclick="updateHINEScore('hine_social_orientation', '5', this)" data-cell="hine_social_orientation_5" class="hine_social_orientation_field text-center @if(isset($hine_details->hine_social_orientation) && $hine_details->hine_social_orientation == '5') selected-score @endif">
                                <p>Avoiding, withdrawn</p>
                            </td>
                            <td onclick="updateHINEScore('hine_social_orientation', '4', this)" data-cell="hine_social_orientation_4" class="hine_social_orientation_field text-center @if(isset($hine_details->hine_social_orientation) && $hine_details->hine_social_orientation == '4') selected-score @endif">
                                <p>Hesitant</p>
                            </td>
                            <td onclick="updateHINEScore('hine_social_orientation', '3', this)" data-cell="hine_social_orientation_3" class="hine_social_orientation_field text-center @if(isset($hine_details->hine_social_orientation) && $hine_details->hine_social_orientation == '3') selected-score @endif">
                                <p>Accepts approach</p>
                            </td>
                            <td onclick="updateHINEScore('hine_social_orientation', '2', this)" data-cell="hine_social_orientation_2" class="hine_social_orientation_field text-center @if(isset($hine_details->hine_social_orientation) && $hine_details->hine_social_orientation == '2') selected-score @endif">
                                <p>Friendly</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td class="vertical-top">
                                @php $hine_details->hine_social_orientation_status = isset($hine_details->hine_social_orientation_status) ? $hine_details->hine_social_orientation_status : 1; @endphp
                                <span class="avoid-wrap">{{ Form::radio('hine_social_orientation_status', 1, ($hine_details->hine_social_orientation_status == 1 ? true : false)) }} Symmetric </span><br/> 
                                <span class="avoid-wrap">{{ Form::radio('hine_social_orientation_status', 2, ($hine_details->hine_social_orientation_status == 2 ? true : false)) }} Asymmetric </span><br/>
                                {!! Form::textarea('hine_social_orientation_asymmetric', @$hine_details->hine_social_orientation_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'hine_social_orientation_status_2', 'rows'=>'5', 'cols'=>'8']) !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('hine_interpretation','Interpretation:') !!}
            {!! Form::select('hine_interpretation', $hnne_hine_interpretation_options, null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('hine_interpretation_others','Note:') !!}
            {!! Form::textarea('hine_interpretation_others', null,['class'=>'form-control', 'rows'=>2]) !!}
        </div>
    </div>
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
    <div class="col-md-12 text-center mtb-20">
        <input type="hidden" name="total_hine_score" class="total_hine_score_input" value="@if(isset($hine_details->total_hine_score)){{ $hine_details->total_hine_score }}@endif">
        <label class="label label-success total-score-label">TOTAL HINE SCORE: <span class="total_hine_score"></span></label>
    </div>
</div>
<script type="text/javascript">
    function updateHINEScore(type, score, element) {
        $('input[name="' + type + '"]').val(score);
        $('.' + type + '_field').removeClass('selected-score');
        $('#' + type).val(score);
        $(element).addClass('selected-score');

        eachAssessmentCalculation(type);

        calculateHINEScore();
    } 

    function eachAssessmentCalculation(type) {

        var type_name = $('#'+type).attr('name');
        type_name = type_name.replace('[]', '');    

        var total = 0;
        $('input[name^="'+type_name+'"]').each(function () {
            if (typeof $(this).attr('id') != 'undefined' && $(this).val() != '') {
                total += parseInt($(this).val());
            }
        });

        $('#'+type).parents('table').find('.btn-total b').html(total);
    }

    eachAssessmentCalculation('hine_facial_appearance');
    eachAssessmentCalculation('hine_head');
    eachAssessmentCalculation('hine_quantity');
    eachAssessmentCalculation('hine_scraf_sign');
    eachAssessmentCalculation('hine_arm_production');
    eachAssessmentCalculation('hine_head_control');
    eachAssessmentCalculation('hine_conscious_state');

    function calculateHINEScore() {
        var total_hine_score = 0;
        var unused = 0;
        $('.hine-container:not(.exception-container) input[type="hidden"][name^="hine_"]').each(function() {
            if ($(this).val()) {
                total_hine_score = parseInt($(this).val()) + total_hine_score;
                unused = 1;
            }
        });
        var g_weeks = (!isNaN($('#g_weeks').val())) ? parseInt($('#g_weeks').val()) : 0;
        var g_days = (!isNaN($('#g_days').val())) ? parseInt($('#g_days').val()) : 0;
        var dob = $('#DOB').val();
        dob = dob.split('-');
        dob = new Date(dob[2], dob[1], dob[0]);
        var calculate_date = $('#visit_date').val();
        calculate_date = calculate_date.split('-');
        calculate_date = new Date(calculate_date[2], calculate_date[1], calculate_date[0]);

        if (unused && g_weeks > 0) {

            var age_group = '';
            var baby_response = '';
            switch (true) {

                case (g_weeks <= 32):
                age_group = "very_preterm";
                var corrected_age = calculatedCorrectedGestation(g_weeks, g_days, dob, calculate_date);
                if (typeof corrected_age != 'undefined') {
                    corrected_age = corrected_age['corrected_age_month'];
                    if (corrected_age < 4) {
                        if (total_hine_score >= 51 && total_hine_score <= 67)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the corrected age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the corrected age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    } else if (corrected_age >= 4 && corrected_age < 7) {
                        if (total_hine_score >= 52 && total_hine_score <= 71)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the corrected age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the corrected age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    } else if (corrected_age >= 7 && corrected_age < 10) {
                        if (total_hine_score >= 57 && total_hine_score <= 76)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the corrected age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the corrected age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    } else if (corrected_age >= 10) {
                        if (total_hine_score >= 60 && total_hine_score <= 77)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the corrected age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the corrected age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    }
                }
                break;

                case (g_weeks > 32 && g_weeks <= 36):
                age_group = "late_preterm";

                var corrected_age = calculatedCorrectedGestation(g_weeks, g_days, dob, calculate_date);
                if (typeof corrected_age != 'undefined') {
                    corrected_age = corrected_age['corrected_age_month'];
                    if (corrected_age < 4) {
                        if (total_hine_score >= 57 && total_hine_score <= 69)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the corrected age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the corrected age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    } else if (corrected_age >= 4 && corrected_age < 7) {
                        if (total_hine_score >= 60 && total_hine_score <= 72)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the corrected age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the corrected age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    } else if (corrected_age >= 7 && corrected_age < 10) {
                        if (total_hine_score >= 63 && total_hine_score <= 75)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the corrected age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the corrected age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    } else if (corrected_age >= 10) {
                        if (total_hine_score >= 64 && total_hine_score <= 77)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the corrected age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the corrected age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    }   
                }
                break;

                case (g_weeks > 36):
                age_group = "term";
                var corrected_age = calculateCorrectedAge(g_weeks, g_days, dob, calculate_date);
                if (typeof corrected_age != 'undefined') {
                    corrected_age = corrected_age['corrected_age_month'];
                    if (corrected_age < 4) {
                        if (total_hine_score >= 62 && total_hine_score <= 69)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    } else if (corrected_age >= 4 && corrected_age < 7) {
                        if (total_hine_score >= 64 && total_hine_score <= 74)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    } else if (corrected_age >= 7 && corrected_age < 10) {
                        if (total_hine_score >= 65 && total_hine_score <= 78)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    } else if (corrected_age >= 10) {
                        if (total_hine_score >= 65 && total_hine_score <= 78)  {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-danger').addClass('label-success');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Normal response for the age.").removeClass('label-danger').addClass('label-success');
                            baby_response = 'N';
                        } else {
                            $('.total_hine_score').text(total_hine_score).parent().removeClass('label-success').addClass('label-danger');
                            $('#hine_tab .total_score').text("("+total_hine_score+") Weak response for the age.").removeClass('label-success').addClass('label-danger');
                            baby_response = 'W';
                        }
                    }
                }
                break;
            }
            $('#hine_tab .total_score').parent().removeClass('hide');
            $('.total_hine_score_input').val(total_hine_score+'-'+baby_response);
        }
    }
    if (window.location.href.split('/')[5] != 'create') {
        calculateHINEScore();
    }

    function calculatedCorrectedGestation(gestation_weeks, gestation_days, dob, calculate_date) {
        var result = [];
        if (gestation_weeks != '' && dob != '' && calculate_date != '') {
            var chronological_age = calculateDays(dob, calculate_date);
            var corrected_age = (40 - parseInt(gestation_weeks)) * 7;
            if (isNaN(gestation_days)) {
                corrected_age = corrected_age;
            } else {
                corrected_age = corrected_age + parseInt(gestation_days);            
            }
            corrected_age_days = chronological_age - corrected_age;
            var corrected_age_weeks = parseInt(corrected_age_days / 7);
            var corrected_age_rem_days = corrected_age_days % 7;
            var corrected_age_month = corrected_age_weeks / 4;
            if (corrected_age_weeks > 0 || (corrected_age_weeks == 0 && corrected_age_rem_days > 0)) {
                result['corrected_age_month'] = corrected_age_month;
                result['corrected_age_weeks'] = corrected_age_weeks;
                result['corrected_age_days'] = corrected_age_rem_days
            } else {
                result['corrected_age_month'] =  0;
                result['corrected_age_weeks'] =  0;
                result['corrected_age_days'] = 0
            }
        } else {
            result['corrected_age_month'] =  0;
            result['corrected_age_weeks'] =  0;
            result['corrected_age_days'] = 0
        }
        return result;
    }

    function calculateCorrectedAge(gestation_weeks, gestation_days, dob, calculate_date) {
        var result = [];
        if (gestation_weeks != '' && gestation_days != '' && dob != '' && calculate_date != '') {
            var datediff = calculateDays(dob, calculate_date);
            var chronological_age_days = datediff / (60 * 60 * 24);
            var corrected_age = chronological_age_days - (((40 - gestation_weeks) * 7) + gestation_days);
            var corrected_age_weeks = parseInt(corrected_age / 7);
            var corrected_age_rem_days = corrected_age % 7;
            var corrected_age_month = corrected_age_weeks / 4;

            if (corrected_age > 0) {
                result['corrected_age_month'] = corrected_age_month;
                result['corrected_age_weeks'] = corrected_age_weeks;
                result['corrected_age_days'] = corrected_age_rem_days
            } else {
                result['corrected_age_month'] =  0;
                result['corrected_age_weeks'] =  0;
                result['corrected_age_days'] = 0
            }
        } else {
            result['corrected_age_month'] =  0;
            result['corrected_age_weeks'] =  0;
            result['corrected_age_days'] = 0
        }
        return result;
    }

    function calculateDays(startDate, endDate) {
        if ((typeof endDate != 'undefined' && endDate != null && Date.parse(endDate) > 0) && (typeof startDate != 'undefined' && startDate != null && Date.parse(startDate) > 0)) {
            return Math.floor((endDate.getTime() - startDate.getTime()) / 86400000);
        }
    }

    var custom_hine_trigger = false;

    $(document).ready(function() {
        $('#hine_form input[type="radio"][value="2"][checked="checked"]').each(function () {
            custom_hine_trigger = true;
            $(this).trigger('change');
        });
    });

    $(document).on('change', '#hine_form input[type="radio"]', function() {
        var value = $(this).val();
        var field_name = $(this).attr('name');

        if (custom_hine_trigger == false) {
            if (value == 2) {
                $('#'+field_name+'_2').val('').removeClass('hide').focus();
            } else {
                $('#'+field_name+'_2').val('').addClass('hide');
            }
        } else {
            if (value == 2) {
                $('#'+field_name+'_2').removeClass('hide');
            } else {
                $('#'+field_name+'_2').addClass('hide');
            }
            custom_hine_trigger = false;
        }
    });
    $('#hine_form .reset').on('click', function() {
        $(this).parents('tr').find('td').removeClass('selected-score');
        $(this).parents('tr').find('td:first-child input').val('');
        var type = $(this).parents('tr').find('td:first-child').find('input').attr('name');
        updateHINEScore(type, '');
    });
</script>
