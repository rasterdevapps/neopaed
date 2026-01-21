<style type="text/css">
    .hnne-container .row-head {
    /*writing-mode: vertical-rl;
    -ms-writing-mode: tb-rl;
    writing-mode: tb-rl;
    -webkit-writing-mode: vertical-rl;
    writing-mode: vertical-rl;
    vertical-align: middle !important;*/
    transform: rotate(180deg);
    min-width: 70px;
}

.hnne-container .row-head strong {
    writing-mode: vertical-rl;
    -ms-writing-mode: tb-rl;
    writing-mode: tb-rl;
    -webkit-writing-mode: vertical-rl;
    writing-mode: vertical-rl;
}

.hnne-container .table td:not(.no-border) {
    border: 1px solid #888;
    border-collapse: collapse;
}

.hnne-container .table td {
    position: relative;
}

.hnne-container .image-container {
    display: table-cell;
    position: absolute;
    bottom: 7px;
    left: 15%;
}

.hnne-container .image-container img {
    vertical-align: bottom;
}

.hnne-container .side-indication:before {
    position: absolute;
    bottom: -10px;
    left: -13px;
    content: 'R';
    font-size: 13px;
    font-weight: 600;
}

.hnne-container .side-indication:after {
    position: absolute;
    bottom: -10px;
    right: -13px;
    content: 'L';
    font-size: 13px;
    font-weight: 600;
}

.hnne-container .image-container i {
    display: block;
    text-align: center;
    font-size: 20px;
}

.hnne-container .popliteal-angle .image-container {
    bottom: 30% !important;
    left: 30% !important;
}

.hnne-container .popliteal-angle .image-container i {
    font-size: 13px;
}

.hnne-container .arm-recoil td img {
    min-width: 125%;
}

.hnne-container .posture td p,
.hnne-container .leg-recoil td p {
    padding-bottom: 30px !important;
}

.hnne-container .ventral-suspension td p {
    padding-bottom: 40px !important;
}

.hnne-container .head-lag td p {
    padding-bottom: 50px !important;
}

.hnne-container .arm-traction td p,
.arm-recoil td p {
    padding-bottom: 70px !important;
}

.hnne-container .bg-secondary {
    background-color: #d5d5d5;
}

.hnne-container .no-border {
    border: 0px !important;
}

.hnne-container .sub-table tbody td {
    padding: 3px 5px !important;
}

.hnne-container .sub-table {
    margin-bottom: 0px !important;
}

.hnne-container .selected-score {
    background-color: #d4f5ff;
    box-shadow: 0px 0px 10px #999;
    transition: all .1s ease;
}

.hnne-container .valign-middle td {
    vertical-align: middle !important;
}

.hnne-container .table-list {
    padding-left: 5px !important;
    padding-bottom: 80px;
}

.total-score-label {
    font-size: 20px !important;
    padding: 5px 20px;
}

.selected-cell {
    background-color: #05b005 !important;
    color: #fff;
}

.not-valid-value-cell {
    background-color: red !important;
    color: #fff;
}

.hnne-container .table-responsive {
    border: 1px solid black;
    margin-bottom: 15px;
} 
.hnne-container .table {
    margin-bottom: 0px !important;
} 
.hnne-container h3 {
    color: white;
    background-color: var(--theme-color);
    margin: 0px;
    padding: 15px;
}
#hnne_form.active {
    display: grid;
}
#hnne_form textarea {
    margin-top: 5px;
}
#hnne_form .vertical-top {
    vertical-align: top !important;
}
#hnne_form .btn-total {
    background-color: var(--theme-color);
    color: white;
    font-size: 16px;
    font-weight: bold;
}
#hnne_form .reset {
    position: absolute;
    bottom: 0px;
    left: 0px;
    float: right;
    padding: 0px 3px;
    box-shadow: none;
    background-color: transparent;
    border: 0px;
    color: red;
}
.back-to-screeening.fixed-nav {
    position: fixed;
    top: 49px;
    width: 94%;
    left: 5%;
    z-index: 2;
    padding: 10px;
    background-color: #f9f9f9;
}
</style>
<div class="row">
    <div class="col-xs-12 text-right back-to-screeening">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
    <div class="col-md-12 text-center mtb-20">
        <input type="hidden" name="total_hnne_score_copy" class="total_hnne_score_input" value="@if(isset($hnne_details->total_hnne_score)){{ $hnne_details->total_hnne_score }}@endif">
        <label class="label label-success total-score-label">TOTAL HNNE SCORE: <span class="total_score_element"></span></label>
    </div>
</div>
<div class="col-md-12" id="hnne-holder">
    <div id="hnnescreening1">
        <div class="row hnne-container">
            <div class="table-responsive">
                <h3><strong>Posture</strong></h3>
                <table class="table posture-table">
                    <tbody>
                        <tr class="posture">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>POSTURE</strong>
                                <input type="hidden" class="hnne_scores" name="posture_score" value="@if(isset($hnne_details->posture_score)){{ $hnne_details->posture_score }}@endif">
                                <input type="hidden" name="posture[]" id="posture_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('posture_score', '1', this)" data-cell="posture_score_1" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == 1) selected-score @endif">
                                <p>arms & legs extended or very slightly flexed</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/posture-1.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('posture_score', '1.5', this)" data-cell="posture_score_1-5" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('posture_score', '2', this)" data-cell="posture_score_2" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '2') selected-score @endif">
                                <p>legs slightly flexed</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/posture-2.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('posture_score', '2.5', this)" data-cell="posture_score_2-5" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '2.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('posture_score', '3', this)" data-cell="posture_score_3" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '3') selected-score @endif">
                                <p>legs well-flexed but not adducted</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/posture-3.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('posture_score', '3.5', this)" data-cell="posture_score_3-5" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('posture_score', '4', this)" data-cell="posture_score_4" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '4') selected-score @endif">
                                <p>legs well flexed & adducted near abdomen</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/posture-4.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('posture_score', '4.5', this)" data-cell="posture_score_4-5" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('posture_score', '5', this)" data-cell="posture_score_5" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '5') selected-score @endif">
                                <p>abnormal postures: marked extension of legs / strong arm flexion/ opisthotonus</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/posture-5.svg">
                                </div>
                            </td>
                            <td width="7%">
                                @php $hnne_details->posture_status = isset($hnne_details->posture_status) ? $hnne_details->posture_status : 1; @endphp
                                {{ Form::radio('posture_status', 1, ($hnne_details->posture_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('posture_status', 2, ($hnne_details->posture_status == 2 ? true : false)) }} Asymmetric
                                {!! Form::textarea('posture_asymmetric', @$hnne_details->posture_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'posture_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered posture_score_table">
                                    <tr>
                                        <td>1</td>
                                        <td>.5</td>
                                        <td>2</td>
                                        <td>.5</td>
                                        <td>3</td>
                                        <td>.5</td>
                                        <td>4</td>
                                        <td>.5</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td class="posture_score_valid_1_first_group">3</td>
                                        <td class="posture_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary posture_score_valid_2_first_group">9</td>
                                        <td class="bg-secondary posture_score_valid_2-5_first_group">6</td>
                                        <td class="bg-secondary posture_score_valid_3_first_group">60</td>
                                        <td class="bg-secondary posture_score_valid_3-5_first_group">9</td>
                                        <td class="bg-secondary posture_score_valid_4_first_group">12</td>
                                        <td class="posture_score_valid_4-5_first_group">0</td>
                                        <td class="posture_score_valid_5_first_group">1</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="posture_score_valid_1_second_group">1</td>
                                        <td class="posture_score_valid_1-5_second_group">0</td>
                                        <td class="posture_score_valid_2_second_group">6</td>
                                        <td class="bg-secondary posture_score_valid_2-5_second_group">2</td>
                                        <td class="bg-secondary posture_score_valid_3_second_group">61</td>
                                        <td class="bg-secondary posture_score_valid_3-5_second_group">16</td>
                                        <td class="bg-secondary posture_score_valid_4_second_group">12</td>
                                        <td class="posture_score_valid_4-5_second_group">1</td>
                                        <td class="posture_score_valid_5_second_group">1</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="posture_score_valid_1_third_group">2</td>
                                        <td class="posture_score_valid_1-5_third_group">0</td>
                                        <td class="posture_score_valid_2_third_group">4</td>
                                        <td class="posture_score_valid_2-5_third_group">2</td>
                                        <td class="bg-secondary posture_score_valid_3_third_group">65</td>
                                        <td class="bg-secondary posture_score_valid_3-5_third_group">17</td>
                                        <td class="bg-secondary posture_score_valid_4_third_group">8</td>
                                        <td class="posture_score_valid_4-5_third_group">0</td>
                                        <td class="posture_score_valid_5_third_group">2</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="posture_score_valid_1_fourth_group">0</td>
                                        <td class="posture_score_valid_1-5_fourth_group">0</td>
                                        <td class="posture_score_valid_2_fourth_group">0</td>
                                        <td class="posture_score_valid_2-5_fourth_group">2</td>
                                        <td class="bg-secondary posture_score_valid_3_fourth_group">81</td>
                                        <td class="bg-secondary posture_score_valid_3-5_fourth_group">4</td>
                                        <td class="bg-secondary posture_score_valid_4_fourth_group">9</td>
                                        <td class="posture_score_valid_4-5_fourth_group">0</td>
                                        <td class="posture_score_valid_5_fourth_group">4</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="posture_score_valid_1_term_group">0</td>
                                        <td class="posture_score_valid_1-5_term_group">0</td>
                                        <td class="posture_score_valid_2_term_group">0</td>
                                        <td class="posture_score_valid_2-5_term_group">0</td>
                                        <td class="posture_score_valid_3_term_group">6</td>
                                        <td class="posture_score_valid_3-5_term_group">3</td>
                                        <td class="bg-secondary posture_score_valid_4_term_group">90</td>
                                        <td class="posture_score_valid_4-5_term_group">1</td>
                                        <td class="posture_score_valid_5_term_group">0</td>
                                        <td width="50%" style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="arm-recoil">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>ARM RECOIL</strong>
                                <input type="hidden" class="hnne_scores" name="arm_recoil_score" value="@if(isset($hnne_details->arm_recoil_score)){{ $hnne_details->arm_recoil_score }}@endif">
                                <input type="hidden" name="posture[]" id="arm_recoil_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('arm_recoil_score', '1', this)" data-cell="arm_recoil_score_1" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '1') selected-score @endif">
                                <p>arms do not flex</p>
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/arm-recoil-1.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('arm_recoil_score', '1.5', this)" data-cell="arm_recoil_score_1-5" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('arm_recoil_score', '2', this)" data-cell="arm_recoil_score_2" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '2') selected-score @endif">
                                <p>arms flex slowly, not always & not completely</p>
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/arm-recoil-2.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('arm_recoil_score', '2.5', this)" data-cell="arm_recoil_score_2-5" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '2.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('arm_recoil_score', '3', this)" data-cell="arm_recoil_score_3" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '3') selected-score @endif">
                                <p>arms flex slowly, more completely</p>
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/arm-recoil-3.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('arm_recoil_score', '3.5', this)" data-cell="arm_recoil_score_3-5" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('arm_recoil_score', '4', this)" data-cell="arm_recoil_score_4" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '4') selected-score @endif">
                                <p>arms flex quickly and completely</p>
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/arm-recoil-4.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('arm_recoil_score', '4.5', this)" data-cell="arm_recoil_score_4-5" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('arm_recoil_score', '5', this)" data-cell="arm_recoil_score_5" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '5') selected-score @endif">
                                <p>arms difficult to extend and may snap back forcefully</p>
                                <div class="image-container">
                                </div>
                            </td>
                            <td width="7%">
                                @php $hnne_details->arm_recoil_status = isset($hnne_details->arm_recoil_status) ? $hnne_details->arm_recoil_status : 1; @endphp
                                {{ Form::radio('arm_recoil_status', 1, ($hnne_details->arm_recoil_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('arm_recoil_status', 2, ($hnne_details->arm_recoil_status == 2 ? true : false)) }} Asymmetric
                                {!! Form::textarea('arm_recoil_asymmetric', @$hnne_details->arm_recoil_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'arm_recoil_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered arm_recoil_score_table">
                                    <tr>
                                        <td class="arm_recoil_score_valid_1_first_group">3</td>
                                        <td class="arm_recoil_score_valid_1-5_first_group">1</td>
                                        <td class="bg-secondary arm_recoil_score_valid_2_first_group">9</td>
                                        <td class="bg-secondary arm_recoil_score_valid_2-5_first_group">9</td>
                                        <td class="bg-secondary arm_recoil_score_valid_3_first_group">44</td>
                                        <td class="bg-secondary arm_recoil_score_valid_3-5_first_group">9</td>
                                        <td class="bg-secondary arm_recoil_score_valid_4_first_group">23</td>
                                        <td class="arm_recoil_score_valid_4-5_first_group">2</td>
                                        <td class="arm_recoil_score_valid_5_first_group">0</td>
                                        <td><strong>25-27W</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="arm_recoil_score_valid_1_second_group">1</td>
                                        <td class="arm_recoil_score_valid_1-5_second_group">1</td>
                                        <td class="arm_recoil_score_valid_2_second_group">3</td>
                                        <td class="arm_recoil_score_valid_2-5_second_group">4</td>
                                        <td class="bg-secondary arm_recoil_score_valid_3_second_group">42</td>
                                        <td class="bg-secondary arm_recoil_score_valid_3-5_second_group">15</td>
                                        <td class="bg-secondary arm_recoil_score_valid_4_second_group">33</td>
                                        <td class="arm_recoil_score_valid_4-5_second_group">0</td>
                                        <td class="arm_recoil_score_valid_5_second_group">1</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="arm_recoil_score_valid_1_third_group">1</td>
                                        <td class="arm_recoil_score_valid_1-5_third_group">0</td>
                                        <td class="arm_recoil_score_valid_1_third_group">8</td>
                                        <td class="bg-secondary arm_recoil_score_valid_2-5_third_group">3</td>
                                        <td class="bg-secondary arm_recoil_score_valid_3_third_group">42</td>
                                        <td class="bg-secondary arm_recoil_score_valid_3-5_third_group">10</td>
                                        <td class="bg-secondary arm_recoil_score_valid_4_third_group">36</td>
                                        <td class="arm_recoil_score_valid_4-5_third_group">0</td>
                                        <td class="arm_recoil_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="arm_recoil_score_valid_1_fourth_group">0</td>
                                        <td class="arm_recoil_score_valid_1-5_fourth_group">0</td>
                                        <td class="arm_recoil_score_valid_2_fourth_group">2</td>
                                        <td class="arm_recoil_score_valid_2-5_fourth_group">2</td>
                                        <td class="bg-secondary arm_recoil_score_valid_3_fourth_group">54</td>
                                        <td class="bg-secondary arm_recoil_score_valid_3-5_fourth_group">15</td>
                                        <td class="bg-secondary arm_recoil_score_valid_4_fourth_group">25</td>
                                        <td class="arm_recoil_score_valid_4-5_fourth_group">0</td>
                                        <td class="arm_recoil_score_valid_5_fourth_group">2</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="arm_recoil_score_valid_1_term_group">0</td>
                                        <td class="arm_recoil_score_valid_1-5_term_group">0</td>
                                        <td class="arm_recoil_score_valid_2_term_group">5</td>
                                        <td class="arm_recoil_score_valid_2-5_term_group">2</td>
                                        <td class="bg-secondary arm_recoil_score_valid_3_term_group">22</td>
                                        <td class="bg-secondary arm_recoil_score_valid_3-5_term_group">3</td>
                                        <td class="bg-secondary arm_recoil_score_valid_4_term_group">67</td>
                                        <td class="arm_recoil_score_valid_4-5_term_group">1</td>
                                        <td class="arm_recoil_score_valid_5_term_group">0</td>
                                        <td width="50%" style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="arm-traction">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>ARM TRACTION</strong>
                                <input type="hidden" class="hnne_scores" name="arm_traction_score" value="@if(isset($hnne_details->arm_traction_score)){{ $hnne_details->arm_traction_score }}@endif">
                                <input type="hidden" name="posture[]" id="arm_traction_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('arm_traction_score', '1', this)" data-cell="arm_traction_score_1" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '1') selected-score @endif ">
                                <p>arm remains straight - no resistance felt</p>
                                <div class="image-container side-indication">
                                    <i>&#8593;</i>
                                    <img src="{{ url('/') }}/public/img/hnne/arm-traction-1.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('arm_traction_score', '1.5', this)" data-cell="arm_traction_score_1-5" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('arm_traction_score', '2', this)" data-cell="arm_traction_score_2" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '2') selected-score @endif ">
                                <p>arm flexes slightly or some resistance felt</p>
                                <div class="image-container side-indication">
                                    <i>&#8593;</i>
                                    <img src="{{ url('/') }}/public/img/hnne/arm-traction-2.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('arm_traction_score', '2.5', this)" data-cell="arm_traction_score_2-5" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '2.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('arm_traction_score', '3', this)" data-cell="arm_traction_score_3" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '3') selected-score @endif">
                                <p>arm flexes well till shoulder lifts, then straightens</p>
                                <div class="image-container side-indication">
                                    <i>&#8593;</i>
                                    <img src="{{ url('/') }}/public/img/hnne/arm-traction-3.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('arm_traction_score', '3.5', this)" data-cell="arm_traction_score_3-5" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('arm_traction_score', '4', this)" data-cell="arm_traction_score_4" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '4') selected-score @endif ">
                                <p>arm flexes at ~100 and maintained as shoulder lifts</p>
                                <div class="image-container side-indication">
                                    <i>&#8593;</i>
                                    <img src="{{ url('/') }}/public/img/hnne/arm-traction-4.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('arm_traction_score', '4.5', this)" data-cell="arm_traction_score_4-5" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('arm_traction_score', '5', this)" data-cell="arm_traction_score_5" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score_field) && $hnne_details->arm_traction_score_field == '5') selected-score @endif ">
                                <p>arms flexed (<100 ) & maintained when body lifts up</p>
                                <div class="image-container side-indication">
                                    <i>&#8593;</i>
                                    <img src="{{ url('/') }}/public/img/hnne/arm-traction-5.svg">
                                </div>
                            </td>
                            <td width="7%">
                                @php $hnne_details->arm_traction_status = isset($hnne_details->arm_traction_status) ? $hnne_details->arm_traction_status : 1; @endphp
                                {{ Form::radio('arm_traction_status', 1, ($hnne_details->arm_traction_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('arm_traction_status', 2, ($hnne_details->arm_traction_status == 2 ? true : false)) }} Asymmetric                                
                                {!! Form::textarea('arm_traction_asymmetric', @$hnne_details->arm_traction_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'arm_traction_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered arm_traction_score_table">
                                    <tr>
                                        <td class="arm_traction_score_valid_1_first_group">3</td>
                                        <td class="arm_traction_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary arm_traction_score_valid_2_first_group">17</td>
                                        <td class="bg-secondary arm_traction_score_valid_2-5_first_group">5</td>
                                        <td class="bg-secondary arm_traction_score_valid_3_first_group">51</td>
                                        <td class="bg-secondary arm_traction_score_valid_3-5_first_group">10</td>
                                        <td class="bg-secondary arm_traction_score_valid_4_first_group">14</td>
                                        <td class="arm_traction_score_valid_4-5_first_group">0</td>
                                        <td class="arm_traction_score_valid_5_first_group">0</td>
                                        <td><strong>25-27W</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="arm_traction_score_valid_1_second_group">7</td>
                                        <td class="arm_traction_score_valid_1-5_second_group">1</td>
                                        <td class="bg-secondary arm_traction_score_valid_2_second_group">14</td>
                                        <td class="bg-secondary arm_traction_score_valid_2-5_second_group">7</td>
                                        <td class="bg-secondary arm_traction_score_valid_3_second_group">45</td>
                                        <td class="bg-secondary arm_traction_score_valid_3-5_second_group">8</td>
                                        <td class="bg-secondary arm_traction_score_valid_4_second_group">18</td>
                                        <td class="arm_traction_score_valid_4-5_second_group">0</td>
                                        <td class="arm_traction_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="arm_traction_score_valid_1_third_group">7</td>
                                        <td class="arm_traction_score_valid_1-5_third_group">2</td>
                                        <td class="bg-secondary arm_traction_score_valid_2_third_group">15</td>
                                        <td class="bg-secondary arm_traction_score_valid_2-5_third_group">4</td>
                                        <td class="bg-secondary arm_traction_score_valid_3_third_group">51</td>
                                        <td class="bg-secondary arm_traction_score_valid_3-5_third_group">7</td>
                                        <td class="bg-secondary arm_traction_score_valid_4_third_group">14</td>
                                        <td class="arm_traction_score_valid_4-5_third_group">0</td>
                                        <td class="arm_traction_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="arm_traction_score_valid_1_fourth_group">6</td>
                                        <td class="arm_traction_score_valid_1-5_fourth_group">2</td>
                                        <td class="bg-secondary arm_traction_score_valid_2_fourth_group">25</td>
                                        <td class="bg-secondary arm_traction_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary arm_traction_score_valid_3_fourth_group">59</td>
                                        <td class="bg-secondary arm_traction_score_valid_3-5_fourth_group">4</td>
                                        <td class="bg-secondary arm_traction_score_valid_4_fourth_group">4</td>
                                        <td class="arm_traction_score_valid_4-5_fourth_group">0</td>
                                        <td class="arm_traction_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="arm_traction_score_valid_1_term_group">0</td>
                                        <td class="arm_traction_score_valid_1-5_term_group">0</td>
                                        <td class="arm_traction_score_valid_2_term_group">1</td>
                                        <td class="arm_traction_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary arm_traction_score_valid_3_term_group">22</td>
                                        <td class="bg-secondary arm_traction_score_valid_3-5_term_group">8</td>
                                        <td class="bg-secondary arm_traction_score_valid_4_term_group">69</td>
                                        <td class="arm_traction_score_valid_4-5_term_group">0</td>
                                        <td class="arm_traction_score_valid_5_term_group">0</td>
                                        <td width="50%" style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="leg-recoil">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>LEG RECOIL</strong>
                                <input type="hidden" class="hnne_scores" name="leg_recoil_score" value="@if(isset($hnne_details->leg_recoil_score)){{ $hnne_details->leg_recoil_score }}@endif">
                                <input type="hidden" name="posture[]" id="leg_recoil_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('leg_recoil_score', '1', this)" data-cell="leg_recoil_score_1" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '1') selected-score @endif">
                                <p>No flexion</p>
                                <div class="image-container">
                                    <i>&#8592; <br> &#8594;</i>
                                    <img src="{{ url('/') }}/public/img/hnne/leg-recoil-1.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_recoil_score', '1.5', this)" data-cell="leg_recoil_score_1-5" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('leg_recoil_score', '2', this)" data-cell="leg_recoil_score_2" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '2') selected-score @endif">
                                <p>Incomplete or variable flexion</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/leg-recoil-2.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_recoil_score', '2.5', this)" data-cell="leg_recoil_score_2-5" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '2.5') selected-score @endif">
                            </td>
                            <td width="15%" onclick="updateHNNEScore('leg_recoil_score', '3', this)" data-cell="leg_recoil_score_3" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '3') selected-score @endif">
                                <p>complete but slow flexion</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/leg-recoil-3.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_recoil_score', '3.5', this)" data-cell="leg_recoil_score_3-5" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('leg_recoil_score', '4', this)" data-cell="leg_recoil_score_4" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '4') selected-score @endif">
                                <p>complete fast flexion</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/leg-recoil-4.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_recoil_score', '4.5', this)" data-cell="leg_recoil_score_4-5" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('leg_recoil_score', '5', this)" data-cell="leg_recoil_score_5" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '5') selected-score @endif">
                                <p>legs difficult to extend; may snap back forcefully</p>
                                <div class="image-container">
                                </div>
                            </td>
                            <td width="7%">
                                @php $hnne_details->leg_recoil_status = isset($hnne_details->leg_recoil_status) ? $hnne_details->leg_recoil_status : 1; @endphp
                                {{ Form::radio('leg_recoil_status', 1, ($hnne_details->leg_recoil_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('leg_recoil_status', 2, ($hnne_details->leg_recoil_status == 2 ? true : false)) }} Asymmetric                                
                                {!! Form::textarea('leg_recoil_asymmetric', @$hnne_details->leg_recoil_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'leg_recoil_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered leg_recoil_score_table">
                                    <tr>
                                        <td class="leg_recoil_score_valid_1_first_group">3</td>
                                        <td class="leg_recoil_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary leg_recoil_score_valid_2_first_group">14</td>
                                        <td class="bg-secondary leg_recoil_score_valid_2-5_first_group">4</td>
                                        <td class="bg-secondary leg_recoil_score_valid_3_first_group">18</td>
                                        <td class="bg-secondary leg_recoil_score_valid_3-5_first_group">5</td>
                                        <td class="bg-secondary leg_recoil_score_valid_4_first_group">52</td>
                                        <td class="leg_recoil_score_valid_4-5_first_group">0</td>
                                        <td class="leg_recoil_score_valid_5_first_group">4</td>
                                        <td><strong>25-27W</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_recoil_score_valid_1_second_group">0</td>
                                        <td class="leg_recoil_score_valid_1-5_second_group">0</td>
                                        <td class="leg_recoil_score_valid_2_second_group">5</td>
                                        <td class="leg_recoil_score_valid_2-5_second_group">2</td>
                                        <td class="bg-secondary leg_recoil_score_valid_3_second_group">24</td>
                                        <td class="bg-secondary leg_recoil_score_valid_3-5_second_group">5</td>
                                        <td class="bg-secondary leg_recoil_score_valid_4_second_group">62</td>
                                        <td class="leg_recoil_score_valid_4-5_second_group">0</td>
                                        <td class="leg_recoil_score_valid_5_second_group">2</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_recoil_score_valid_1_third_group">0</td>
                                        <td class="leg_recoil_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary leg_recoil_score_valid_2_third_group">10</td>
                                        <td class="bg-secondary leg_recoil_score_valid_2-5_third_group">2</td>
                                        <td class="bg-secondary leg_recoil_score_valid_3_third_group">34</td>
                                        <td class="bg-secondary leg_recoil_score_valid_3-5_third_group">2</td>
                                        <td class="bg-secondary leg_recoil_score_valid_4_third_group">50</td>
                                        <td class="leg_recoil_score_valid_4-5_third_group">0</td>
                                        <td class="leg_recoil_score_valid_5_third_group">2</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_recoil_score_valid_1_fourth_group">0</td>
                                        <td class="leg_recoil_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary leg_recoil_score_valid_2_fourth_group">9</td>
                                        <td class="bg-secondary leg_recoil_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary leg_recoil_score_valid_3_fourth_group">38</td>
                                        <td class="bg-secondary leg_recoil_score_valid_3-5_fourth_group">2</td>
                                        <td class="bg-secondary leg_recoil_score_valid_4_fourth_group">49</td>
                                        <td class="leg_recoil_score_valid_4-5_fourth_group">0</td>
                                        <td class="leg_recoil_score_valid_5_fourth_group">2</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_recoil_score_valid_1_term_group">0</td>
                                        <td class="leg_recoil_score_valid_1-5_term_group">0</td>
                                        <td class="leg_recoil_score_valid_2_term_group">3</td>
                                        <td class="leg_recoil_score_valid_2-5_term_group">1</td>
                                        <td class="leg_recoil_score_valid_3_term_group">4</td>
                                        <td class="leg_recoil_score_valid_3-5_term_group">1</td>
                                        <td class="bg-secondary leg_recoil_score_valid_4_term_group">91</td>
                                        <td class="leg_recoil_score_valid_4-5_term_group">0</td>
                                        <td class="leg_recoil_score_valid_5_term_group">0</td>
                                        <td width="50%" style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="leg-traction">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>LEG TRACTION</strong>
                                <input type="hidden" class="hnne_scores" name="leg_traction_score" value="@if(isset($hnne_details->leg_traction_score)){{ $hnne_details->leg_traction_score }}@endif">
                                <input type="hidden" name="posture[]" id="leg_traction_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('leg_traction_score', '1', this)" data-cell="leg_traction_score_1" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '1') selected-score @endif">
                                <p>leg straight - no resistance felt</p>
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/leg-traction-1.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_traction_score', '1.5', this)" data-cell="leg_traction_score_1-5" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('leg_traction_score', '2', this)" data-cell="leg_traction_score_2" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '2') selected-score @endif">
                                <p>leg flexes slightly / some resistance felt</p>
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/leg-traction-2.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_traction_score', '2.5', this)" data-cell="leg_traction_score_2-5" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '2.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('leg_traction_score', '3', this)" data-cell="leg_traction_score_3" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '3') selected-score @endif">
                                <p>leg flexes well till bottom lifts up</p>
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/leg-traction-3.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_traction_score', '3.5', this)" data-cell="leg_traction_score_3-5" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('leg_traction_score', '4', this)" data-cell="leg_traction_score_4" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '4') selected-score @endif">
                                <p>knee remains flexed when bottom up</p>
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/leg-traction-4.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_traction_score', '4.5', this)" data-cell="leg_traction_score_4-5" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('leg_traction_score', '5', this)" data-cell="leg_traction_score_5" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '5') selected-score @endif">
                                <p>flexion stays when back+bottom up</p>
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/leg-traction-5.svg">
                                </div>
                            </td>
                            <td width="7%">
                                @php $hnne_details->leg_traction_status = isset($hnne_details->leg_traction_status) ? $hnne_details->leg_traction_status : 1; @endphp
                                {{ Form::radio('leg_traction_status', 1, ($hnne_details->leg_traction_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('leg_traction_status', 2, ($hnne_details->leg_traction_status == 2 ? true : false)) }} Asymmetric                                
                                {!! Form::textarea('leg_traction_asymmetric', @$hnne_details->leg_traction_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'leg_traction_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered leg_traction_score_table">
                                    <tr>
                                        <td class="leg_traction_score_valid_1_first_group">3</td>
                                        <td class="leg_traction_score_valid_1-5_first_group">1</td>
                                        <td class="bg-secondary leg_traction_score_valid_2_first_group">17</td>
                                        <td class="bg-secondary leg_traction_score_valid_2-5_first_group">6</td>
                                        <td class="bg-secondary leg_traction_score_valid_3_first_group">35</td>
                                        <td class="bg-secondary leg_traction_score_valid_3-5_first_group">6</td>
                                        <td class="bg-secondary leg_traction_score_valid_4_first_group">27</td>
                                        <td class="leg_traction_score_valid_4-5_first_group">1</td>
                                        <td class="leg_traction_score_valid_5_first_group">4</td>
                                        <td><strong>25-27W</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_traction_score_valid_1_second_group">1</td>
                                        <td class="leg_traction_score_valid_1-5_second_group">1</td>
                                        <td class="bg-secondary leg_traction_score_valid_2_second_group">17</td>
                                        <td class="bg-secondary leg_traction_score_valid_2-5_second_group">2</td>
                                        <td class="bg-secondary leg_traction_score_valid_3_second_group">36</td>
                                        <td class="bg-secondary leg_traction_score_valid_3-5_second_group">6</td>
                                        <td class="bg-secondary leg_traction_score_valid_4_second_group">35</td>
                                        <td class="leg_traction_score_valid_4-5_second_group">1</td>
                                        <td class="leg_traction_score_valid_5_second_group">1</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_traction_score_valid_1_third_group">2</td>
                                        <td class="leg_traction_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary leg_traction_score_valid_2_third_group">21</td>
                                        <td class="bg-secondary leg_traction_score_valid_2-5_third_group">8</td>
                                        <td class="bg-secondary leg_traction_score_valid_3_third_group">38</td>
                                        <td class="bg-secondary leg_traction_score_valid_3-5_third_group">5</td>
                                        <td class="bg-secondary leg_traction_score_valid_4_third_group">25</td>
                                        <td class="leg_traction_score_valid_4-5_third_group">0</td>
                                        <td class="leg_traction_score_valid_5_third_group">1</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_traction_score_valid_1_fourth_group">0</td>
                                        <td class="leg_traction_score_valid_1-5_fourth_group">4</td>
                                        <td class="bg-secondary leg_traction_score_valid_2_fourth_group">29</td>
                                        <td class="bg-secondary leg_traction_score_valid_2-5_fourth_group">10</td>
                                        <td class="bg-secondary leg_traction_score_valid_3_fourth_group">43</td>
                                        <td class="bg-secondary leg_traction_score_valid_3-5_fourth_group">2</td>
                                        <td class="bg-secondary leg_traction_score_valid_4_fourth_group">10</td>
                                        <td class="leg_traction_score_valid_4-5_fourth_group">0</td>
                                        <td class="leg_traction_score_valid_5_fourth_group">2</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_traction_score_valid_1_term_group">0</td>
                                        <td class="leg_traction_score_valid_1-5_term_group">0</td>
                                        <td class="leg_traction_score_valid_2_term_group">0</td>
                                        <td class="leg_traction_score_valid_2-5_term_group">1</td>
                                        <td class="bg-secondary leg_traction_score_valid_3_term_group">12</td>
                                        <td class="bg-secondary leg_traction_score_valid_3-5_term_group">12</td>
                                        <td class="bg-secondary leg_traction_score_valid_4_term_group">72</td>
                                        <td class="leg_traction_score_valid_4-5_term_group">0</td>
                                        <td class="leg_traction_score_valid_5_term_group">3</td>
                                        <td width="50%" style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="popliteal-angle">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>POPLITEAL ANGLE</strong>
                                <input type="hidden" class="hnne_scores" name="popliteal_angle_score" value="@if(isset($hnne_details->leg_traction_score)){{ $hnne_details->leg_traction_score }}@endif">
                                <input type="hidden" name="posture[]" id="popliteal_angle_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('popliteal_angle_score', '1', this)" data-cell="popliteal_angle_score_1" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '1') selected-score @endif">
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/popliteal-angle-1.svg">
                                    <i>180 <sup>&deg;</sup></i>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('popliteal_angle_score', '1.5', this)" data-cell="popliteal_angle_score_1-5" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('popliteal_angle_score', '2', this)" data-cell="popliteal_angle_score_2" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '2') selected-score @endif">
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/popliteal-angle-2.svg">
                                    <i>=150 <sup>&deg;</sup></i>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('popliteal_angle_score', '2.5', this)" data-cell="popliteal_angle_score_2-5" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '2.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('popliteal_angle_score', '3', this)" data-cell="popliteal_angle_score_3" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '3') selected-score @endif">
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/popliteal-angle-3.svg">
                                    <i>=110 <sup>&deg;</sup></i>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('popliteal_angle_score', '3.5', this)" data-cell="popliteal_angle_score_3-5" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('popliteal_angle_score', '4', this)" data-cell="popliteal_angle_score_4" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '4') selected-score @endif">
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/popliteal-angle-4.svg">
                                    <i>=90 <sup>&deg;</sup></i>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('popliteal_angle_score', '4.5', this)" data-cell="popliteal_angle_score_4-5" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('popliteal_angle_score', '5', this)" data-cell="popliteal_angle_score_5" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '5') selected-score @endif">
                                <div class="image-container side-indication">
                                    <img src="{{ url('/') }}/public/img/hnne/popliteal-angle-5.svg">
                                    <i><90 <sup>&deg;</sup></i>
                                </div>
                            </td>
                            <td width="7%">
                                @php $hnne_details->popliteal_angle_status = isset($hnne_details->popliteal_angle_status) ? $hnne_details->popliteal_angle_status : 1; @endphp
                                {{ Form::radio('popliteal_angle_status', 1, ($hnne_details->popliteal_angle_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('popliteal_angle_status', 2, ($hnne_details->popliteal_angle_status == 2 ? true : false)) }} Asymmetric                                                            
                                {!! Form::textarea('popliteal_angle_asymmetric', @$hnne_details->popliteal_angle_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'popliteal_angle_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered popliteal_angle_score_table">
                                    <tr>
                                        <td class="popliteal_angle_score_valid_1_first_group">3</td>
                                        <td class="popliteal_angle_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_2_first_group">22</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_2-5_first_group">8</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_3_first_group">46</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_3-5_first_group">6</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_4_first_group">14</td>
                                        <td class="popliteal_angle_score_valid_4-5_first_group">0</td>
                                        <td class="popliteal_angle_score_valid_5_first_group">0</td>
                                        <td><strong>25-27W</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="popliteal_angle_score_valid_1_second_group">5</td>
                                        <td class="popliteal_angle_score_valid_1-5_second_group">1</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_2_second_group">16</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_2-5_second_group">5</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_3_second_group">48</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_3-5_second_group">7</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_4_second_group">17</td>
                                        <td class="popliteal_angle_score_valid_4-5_second_group">1</td>
                                        <td class="popliteal_angle_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="popliteal_angle_score_valid_1_third_group">2</td>
                                        <td class="popliteal_angle_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_2_third_group">15</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_2-5_third_group">10</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_3_third_group">53</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_3-5_third_group">5</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_4_third_group">15</td>
                                        <td class="popliteal_angle_score_valid_4-5_third_group">0</td>
                                        <td class="popliteal_angle_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="popliteal_angle_score_valid_1_fourth_group">2</td>
                                        <td class="popliteal_angle_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_2_fourth_group">26</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_2-5_fourth_group">4</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_3_fourth_group">49</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_3-5_fourth_group">4</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_4_fourth_group">13</td>
                                        <td class="popliteal_angle_score_valid_4-5_fourth_group">0</td>
                                        <td class="popliteal_angle_score_valid_5_fourth_group">2</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="popliteal_angle_score_valid_1_term_group">0</td>
                                        <td class="popliteal_angle_score_valid_1-5_term_group">0</td>
                                        <td class="popliteal_angle_score_valid_2_term_group">5</td>
                                        <td class="popliteal_angle_score_valid_2-5_term_group">5</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_3_term_group">19</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_3-5_term_group">20</td>
                                        <td class="bg-secondary popliteal_angle_score_valid_4_term_group">51</td>
                                        <td class="popliteal_angle_score_valid_4-5_term_group">0</td>
                                        <td class="popliteal_angle_score_valid_5_term_group">0</td>
                                        <td width="50%" style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="head-control">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>HEAD CONTROL (1)</strong>
                                <input type="hidden" class="hnne_scores" name="head_control_score" value="@if(isset($hnne_details->head_control_score)){{ $hnne_details->head_control_score }}@endif">
                                <input type="hidden" name="posture[]" id="head_control_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_control_score', '1', this)" data-cell="head_control_score_1" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '1') selected-score @endif">
                                <p>
                                    no attempt to HEAD CONTROL (1) raise head
                                </p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-control-1.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_score', '1.5', this)" data-cell="head_control_score_1-5" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_control_score', '2', this)" data-cell="head_control_score_2" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '2') selected-score @endif">
                                <p>infant tries: effort better felt than seen</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-control-2.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_score', '2.5', this)" data-cell="head_control_score_2-5" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '2.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_control_score', '3', this)" data-cell="head_control_score_3" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '3') selected-score @endif">
                                <p>raises head but head drops forward or back</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-control-3.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_score', '3.5', this)" data-cell="head_control_score_3-5" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_control_score', '4', this)" data-cell="head_control_score_4" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '4') selected-score @endif">
                                <p>raises head; head remains vertical, wobbles</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-control-4.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_score', '4.5', this)" data-cell="head_control_score_4-5" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" class="head_control_score_field">
                                <div class="image-container">
                                </div>
                            </td>
                            <td width="7%">
                                @php $hnne_details->head_control_status = isset($hnne_details->head_control_status) ? $hnne_details->head_control_status : 1; @endphp
                                {{ Form::radio('head_control_status', 1, ($hnne_details->head_control_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('head_control_status', 2, ($hnne_details->head_control_status == 2 ? true : false)) }} Asymmetric                                                            
                                {!! Form::textarea('head_control_asymmetric', @$hnne_details->head_control_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'head_control_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered head_control_score_table">
                                    <tr>
                                        <td class="head_control_score_valid_1_first_group">3</td>
                                        <td class="head_control_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary head_control_score_valid_2_first_group">17</td>
                                        <td class="bg-secondary head_control_score_valid_2-5_first_group">4</td>
                                        <td class="bg-secondary head_control_score_valid_3_first_group">46</td>
                                        <td class="bg-secondary head_control_score_valid_3-5_first_group">9</td>
                                        <td class="bg-secondary head_control_score_valid_4_first_group">21</td>
                                        <td class="head_control_score_valid_4-5_first_group">0</td>
                                        <td class="head_control_score_valid_5_first_group">0</td>
                                        <td><strong>25-27W</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_score_valid_1_second_group">0</td>
                                        <td class="head_control_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary head_control_score_valid_2_second_group">13</td>
                                        <td class="bg-secondary head_control_score_valid_2-5_second_group">5</td>
                                        <td class="bg-secondary head_control_score_valid_3_second_group">46</td>
                                        <td class="bg-secondary head_control_score_valid_3-5_second_group">12</td>
                                        <td class="bg-secondary head_control_score_valid_4_second_group">24</td>
                                        <td class="head_control_score_valid_4-5_second_group">0</td>
                                        <td class="head_control_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_score_valid_1_third_group">3</td>
                                        <td class="head_control_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary head_control_score_valid_2_third_group">14</td>
                                        <td class="bg-secondary head_control_score_valid_2-5_third_group">2</td>
                                        <td class="bg-secondary head_control_score_valid_3_third_group">48</td>
                                        <td class="bg-secondary head_control_score_valid_3-5_third_group">13</td>
                                        <td class="bg-secondary head_control_score_valid_4_third_group">20</td>
                                        <td class="head_control_score_valid_4-5_third_group">0</td>
                                        <td class="head_control_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_score_valid_1_fourth_group">4</td>
                                        <td class="head_control_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary head_control_score_valid_2_fourth_group">15</td>
                                        <td class="bg-secondary head_control_score_valid_2-5_fourth_group">4</td>
                                        <td class="bg-secondary head_control_score_valid_3_fourth_group">55</td>
                                        <td class="bg-secondary head_control_score_valid_3-5_fourth_group">4</td>
                                        <td class="bg-secondary head_control_score_valid_4_fourth_group">18</td>
                                        <td class="head_control_score_valid_4-5_fourth_group">0</td>
                                        <td class="head_control_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_score_valid_1_term_group">0</td>
                                        <td class="head_control_score_valid_1-5_term_group">0</td>
                                        <td class="head_control_score_valid_2_term_group">0</td>
                                        <td class="head_control_score_valid_2-5_term_group">6</td>
                                        <td class="bg-secondary head_control_score_valid_3_term_group">26</td>
                                        <td class="bg-secondary head_control_score_valid_3-5_term_group">12</td>
                                        <td class="bg-secondary head_control_score_valid_4_term_group">56</td>
                                        <td class="head_control_score_valid_4-5_term_group">0</td>
                                        <td class="head_control_score_valid_5_term_group">0</td>
                                        <td width="50%" style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="head-control-flexor">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>HEAD CONTROL (2)</strong>
                                <input type="hidden" class="hnne_scores" name="head_control_2_score" value="@if(isset($hnne_details->head_control_2_score)){{ $hnne_details->head_control_2_score }}@endif">
                                <input type="hidden" name="posture[]" id="head_control_2_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_control_2_score', '1', this)" data-cell="head_control_2_score_1" class="head_control_2_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '1') selected-score @endif">
                                <p>
                                    no attempt to HEAD CONTROL (1) raise head
                                </p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-control-flxor-1.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_2_score', '1.5', this)" data-cell="head_control_2_score_1-5" class="head_control_2_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_control_2_score', '2', this)" data-cell="head_control_2_score_2" class="head_control_2_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '2') selected-score @endif">
                                <p>infant tries: effort better felt than seen</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-control-flxor-2.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_2_score', '2.5', this)" data-cell="head_control_2_score_2-5" class="head_control_2_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '2.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_control_2_score', '3', this)" data-cell="head_control_2_score_3" class="head_control_2_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '3') selected-score @endif">
                                <p>raises head but head drops forward or back</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-control-flxor-3.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_2_score', '3.5', this)" data-cell="head_control_2_score_3-5" class="head_control_2_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_control_2_score', '4', this)" data-cell="head_control_2_score_4" class="head_control_2_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '4') selected-score @endif">
                                <p>raises head; head remains vertical, wobbles</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-control-flxor-4.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_2_score', '4.5', this)" data-cell="head_control_2_score_4-5" class="head_control_2_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_control_2_score', '5', this)" data-cell="head_control_2_score_5" class="head_control_2_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '5') selected-score @endif">
                                <p>
                                    head upright or extended; cannot be passively flexed
                                </p>
                                <div class="image-container">
                                </div>
                            </td>
                            <td width="7%">
                                @php $hnne_details->head_control_2_status = isset($hnne_details->head_control_2_status) ? $hnne_details->head_control_2_status : 1; @endphp
                                {{ Form::radio('head_control_2_status', 1, ($hnne_details->head_control_2_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('head_control_2_status', 2, ($hnne_details->head_control_2_status == 2 ? true : false)) }} Asymmetric                                                            
                                {!! Form::textarea('head_control_2_asymmetric', @$hnne_details->head_control_2_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'head_control_2_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered head_control_2_score_table">
                                    <tr>
                                        <td class="head_control_2_score_valid_1_first_group">3</td>
                                        <td class="head_control_2_score_valid_1-5_first_group">0</td>
                                        <td class="head_control_2_score_valid_2_first_group">3</td>
                                        <td class="bg-secondary head_control_2_score_valid_2-5_first_group">5</td>
                                        <td class="bg-secondary head_control_2_score_valid_3_first_group">57</td>
                                        <td class="bg-secondary head_control_2_score_valid_3-5_first_group">11</td>
                                        <td class="bg-secondary head_control_2_score_valid_4_first_group">21</td>
                                        <td class="head_control_2_score_valid_4-5_first_group">0</td>
                                        <td class="head_control_2_score_valid_5_first_group">0</td>
                                        <td><strong>25-27W</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_2_score_valid_1_second_group">1</td>
                                        <td class="head_control_2_score_valid_1-5_second_group">2</td>
                                        <td class="head_control_2_score_valid_2_second_group">6</td>
                                        <td class="bg-secondary head_control_2_score_valid_2-5_second_grou">4</td>
                                        <td class="bg-secondary head_control_2_score_valid_3_second_group">50</td>
                                        <td class="bg-secondary head_control_2_score_valid_3-5_second_group">13</td>
                                        <td class="bg-secondary head_control_2_score_valid_4_second_group">24</td>
                                        <td class="head_control_2_score_valid_4-5_second_group">0</td>
                                        <td class="head_control_2_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_2_score_valid_1_third_group">1</td>
                                        <td class="head_control_2_score_valid_1-5_third_group">0</td>
                                        <td class="head_control_2_score_valid_2_third_group">2</td>
                                        <td class="head_control_2_score_valid_2-5_third_group">2</td>
                                        <td class="bg-secondary head_control_2_score_valid_3_third_group">63</td>
                                        <td class="bg-secondary head_control_2_score_valid_3-5_third_group">11</td>
                                        <td class="bg-secondary head_control_2_score_valid_4_third_group">21</td>
                                        <td class="head_control_2_score_valid_4-5_third_group">0</td>
                                        <td class="head_control_2_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_2_score_valid_1_fourth_group">0</td>
                                        <td class="head_control_2_score_valid_1-5_fourth_group">0</td>
                                        <td class="head_control_2_score_valid_2_fourth_group">4</td>
                                        <td class="head_control_2_score_valid_2-5_fourth_group">2</td>
                                        <td class="bg-secondary head_control_2_score_valid_3_fourth_group">77</td>
                                        <td class="bg-secondary head_control_2_score_valid_3-5_fourth_group">2</td>
                                        <td class="bg-secondary head_control_2_score_valid_4_fourth_group">15</td>
                                        <td class="head_control_2_score_valid_4-5_fourth_group">0</td>
                                        <td class="head_control_2_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_2_score_valid_1_term_group">0</td>
                                        <td class="head_control_2_score_valid_1-5_term_group">0</td>
                                        <td class="head_control_2_score_valid_2_term_group">0</td>
                                        <td class="head_control_2_score_valid_2-5_term_group">4</td>
                                        <td class="bg-secondary head_control_2_score_valid_3_term_group">29</td>
                                        <td class="bg-secondary head_control_2_score_valid_3-5_term_group">15</td>
                                        <td class="bg-secondary head_control_2_score_valid_4_term_group">52</td>
                                        <td class="head_control_2_score_valid_4-5_term_group">0</td>
                                        <td class="head_control_2_score_valid_5_term_group">0</td>
                                        <td width="50%" style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="head-lag">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>HEAD LAG</strong>
                                <input type="hidden" class="hnne_scores" name="head_lag_score" value="@if(isset($hnne_details->head_lag_score) ){{ $hnne_details->head_lag_score }}@endif">
                                <input type="hidden" name="posture[]" id="head_lag_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_lag_score', '1', this)" data-cell="head_lag_score_1" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '1') selected-score @endif">
                                <p>
                                    head drops back & stays
                                </p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-lag-1.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_lag_score', '1.5', this)" data-cell="head_lag_score_1-5" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_lag_score', '2', this)" data-cell="head_lag_score_2" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '2') selected-score @endif">
                                <p>tries to lift head but it drops back</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-lag-2.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_lag_score', '2.5', this)" data-cell="head_lag_score_2-5" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '2.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_lag_score', '3', this)" data-cell="head_lag_score_3" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '3') selected-score @endif">
                                <p>able to lift head slightly</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-lag-3.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_lag_score', '3.5', this)" data-cell="head_lag_score_3-5" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_lag_score', '4', this)" data-cell="head_lag_score_4" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '4') selected-score @endif">
                                <p>lifts head in line with body</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-lag-4.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_lag_score', '4.5', this)" data-cell="head_lag_score_4-5" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_lag_score', '5', this)" data-cell="head_lag_score_5" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '5') selected-score @endif">
                                <p>
                                    head in front of body
                                </p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/head-lag-5.svg">
                                </div>
                            </td>
                            <td width="7%">
                                @php $hnne_details->head_lag_status = isset($hnne_details->head_lag_status) ? $hnne_details->head_lag_status : 1; @endphp
                                {{ Form::radio('head_lag_status', 1, ($hnne_details->head_lag_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('head_lag_status', 2, ($hnne_details->head_lag_status == 2 ? true : false)) }} Asymmetric                                                            
                                {!! Form::textarea('head_lag_asymmetric', @$hnne_details->head_lag_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'head_lag_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered head_lag_score_table">
                                    <tr>
                                        <td class="head_lag_score_valid_1_first_group">3</td>
                                        <td class="head_lag_score_valid_1-5_first_group">3</td>
                                        <td class="bg-secondary head_lag_score_valid_2_first_group">27</td>
                                        <td class="bg-secondary head_lag_score_valid_2-5_first_group">13</td>
                                        <td class="bg-secondary head_lag_score_valid_3_first_group">36</td>
                                        <td class="bg-secondary head_lag_score_valid_3-5_first_group">3</td>
                                        <td class="bg-secondary head_lag_score_valid_4_first_group">15</td>
                                        <td class="head_lag_score_valid_4-5_first_group">0</td>
                                        <td class="head_lag_score_valid_5_first_group">0</td>
                                        <td><strong>25-27W</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_lag_score_valid_1_second_group">3</td>
                                        <td class="head_lag_score_valid_1-5_second_group">3</td>
                                        <td class="bg-secondary head_lag_score_valid_2_second_group">18</td>
                                        <td class="bg-secondary head_lag_score_valid_2-5_second_group">7</td>
                                        <td class="bg-secondary head_lag_score_valid_3_second_group">40</td>
                                        <td class="bg-secondary head_lag_score_valid_3-5_second_group">14</td>
                                        <td class="bg-secondary head_lag_score_valid_4_second_group">15</td>
                                        <td class="head_lag_score_valid_4-5_second_group">0</td>
                                        <td class="head_lag_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_lag_score_valid_1_third_group">7</td>
                                        <td class="head_lag_score_valid_1-5_third_group">3</td>
                                        <td class="bg-secondary head_lag_score_valid_2_third_group">16</td>
                                        <td class="bg-secondary head_lag_score_valid_2-5_third_group">5</td>
                                        <td class="bg-secondary head_lag_score_valid_3_third_group">46</td>
                                        <td class="bg-secondary head_lag_score_valid_3-5_third_group">7</td>
                                        <td class="bg-secondary head_lag_score_valid_4_third_group">16</td>
                                        <td class="head_lag_score_valid_4-5_third_group">0</td>
                                        <td class="head_lag_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_lag_score_valid_1_fourth_group">4</td>
                                        <td class="head_lag_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary head_lag_score_valid_2_fourth_group">21</td>
                                        <td class="bg-secondary head_lag_score_valid_2-5_fourth_group">4</td>
                                        <td class="bg-secondary head_lag_score_valid_3_fourth_group">56</td>
                                        <td class="bg-secondary head_lag_score_valid_3-5_fourth_group">0</td>
                                        <td class="bg-secondary head_lag_score_valid_4_fourth_group">15</td>
                                        <td class="head_lag_score_valid_4-5_fourth_group">0</td>
                                        <td class="head_lag_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_lag_score_valid_1_term_group">0</td>
                                        <td class="head_lag_score_valid_1-5_term_group">0</td>
                                        <td class="head_lag_score_valid_2_term_group">9</td>
                                        <td class="bg-secondary head_lag_score_valid_2-5_term_group">4</td>
                                        <td class="bg-secondary head_lag_score_valid_3_term_group">44</td>
                                        <td class="bg-secondary head_lag_score_valid_3-5_term_group">12</td>
                                        <td class="bg-secondary head_lag_score_valid_4_term_group">31</td>
                                        <td class="head_lag_score_valid_4-5_term_group">0</td>
                                        <td class="head_lag_score_valid_5_term_group">0</td>
                                        <td width="50%" style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="ventral-suspension">
                            <td class="row-head" width="3%" align="center">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>VENTRAL <br>SUSPENSION</strong>
                                <input type="hidden" class="hnne_scores" name="ventral_suspension_score" value="@if(isset($hnne_details->ventral_suspension_score)){{ $hnne_details->ventral_suspension_score }}@endif">
                                <input type="hidden" name="posture[]" id="ventral_suspension_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('ventral_suspension_score', '1', this)" data-cell="ventral_suspension_score_1" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '1') selected-score @endif">
                                <p>
                                    back curved, head & limbs hang straight
                                </p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/ventral-1.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('ventral_suspension_score', '1.5', this)" data-cell="ventral_suspension_score_1-5" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('ventral_suspension_score', '2', this)" data-cell="ventral_suspension_score_2" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '2') selected-score @endif">
                                <p>back curved, head ↓, limbs slightly flexed</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/ventral-2.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('ventral_suspension_score', '2.5', this)" data-cell="ventral_suspension_score_2-5" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '2.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('ventral_suspension_score', '3', this)" data-cell="ventral_suspension_score_3" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '3') selected-score @endif">
                                <p>back slightly curved, limbs flexed</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/ventral-3.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('ventral_suspension_score', '3.5', this)" data-cell="ventral_suspension_score_3-5" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('ventral_suspension_score', '4', this)" data-cell="ventral_suspension_score_4" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '4') selected-score @endif">
                                <p>back straight, head in line, limbs flexed</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/ventral-4.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('ventral_suspension_score', '4.5', this)" data-cell="ventral_suspension_score_4-5" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('ventral_suspension_score', '5', this)" data-cell="ventral_suspension_score_5" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '5') selected-score @endif">
                                <p>
                                    back straight, head above body, limbs flexed
                                </p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/ventral-5.svg">
                                </div>
                            </td>
                            <td width="7%">
                                @php $hnne_details->ventral_suspension_status = isset($hnne_details->ventral_suspension_status) ? $hnne_details->ventral_suspension_status : 1; @endphp
                                {{ Form::radio('ventral_suspension_status', 1, ($hnne_details->ventral_suspension_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('ventral_suspension_status', 2, ($hnne_details->ventral_suspension_status == 2 ? true : false)) }} Asymmetric                                                            
                                {!! Form::textarea('ventral_suspension_asymmetric', @$hnne_details->ventral_suspension_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'ventral_suspension_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered ventral_suspension_score_table">
                                    <tr>
                                        <td class="ventral_suspension_score_valid_1_first_group">0</td>
                                        <td class="ventral_suspension_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_2_first_group">21</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_2-5_first_group">11</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_3_first_group">38</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_3-5_first_group">11</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_4_first_group">15</td>
                                        <td class="ventral_suspension_score_valid_4-5_first_group">4</td>
                                        <td class="ventral_suspension_score_valid_5_first_group">0</td>
                                        <td><strong>25-27W</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="ventral_suspension_score_valid_1_second_group">3</td>
                                        <td class="ventral_suspension_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_2_second_group">25</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_2-5_second_group">8</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_3_second_group">44</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_3-5_second_group">8</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_4_second_group">10</td>
                                        <td class="ventral_suspension_score_valid_4-5_second_group">0</td>
                                        <td class="ventral_suspension_score_valid_5_second_group">2</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="ventral_suspension_score_valid_1_third_group">3</td>
                                        <td class="ventral_suspension_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_2_third_group">22</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_2-5_third_group">8</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_3_third_group">47</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_3-5_third_group">5</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_4_third_group">14</td>
                                        <td class="ventral_suspension_score_valid_4-5_third_group">1</td>
                                        <td class="ventral_suspension_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="ventral_suspension_score_valid_1_fourth_group">2</td>
                                        <td class="ventral_suspension_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_2_fourth_group">17</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_2-5_fourth_group">2</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_3_fourth_group">56</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_3-5_fourth_group">2</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_4_fourth_group">19</td>
                                        <td class="ventral_suspension_score_valid_4-5_fourth_group">0</td>
                                        <td class="ventral_suspension_score_valid_5_fourth_group">2</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="ventral_suspension_score_valid_1_term_group">0</td>
                                        <td class="ventral_suspension_score_valid_1-5_term_group">0</td>
                                        <td class="ventral_suspension_score_valid_2_term_group">4</td>
                                        <td class="ventral_suspension_score_valid_2-5_term_group">5</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_3_term_group">47</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_3-5_term_group">16</td>
                                        <td class="bg-secondary ventral_suspension_score_valid_4_term_group">28</td>
                                        <td class="ventral_suspension_score_valid_4-5_term_group">0</td>
                                        <td class="ventral_suspension_score_valid_5_term_group">0</td>
                                        <td width="50%" style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hnnescreening2">
        <div class="row hnne-container">
            <div class="table-responsive">
                <h3><strong>Tone pattern items</strong></h3>
                <table class="table">
                    <tbody>
                        <tr class="flexor-tone">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>FLEXOR TONE <br>( compare arm <br>and leg traction )</strong>
                                <input type="hidden" class="hnne_scores" name="flexor_tone_score" value="@if(isset($hnne_details->flexor_tone_score)){{ $hnne_details->flexor_tone_score }}@endif">
                                <input type="hidden" name="tone_pattern_items[]" id="flexor_tone_score">
                            </td>
                            <td width="14%"></td>
                            <td width="3%" onclick="updateHNNEScore('flexor_tone_score', '1.5', this)" data-cell="flexor_tone_score_1-5" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '1.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('flexor_tone_score', '2', this)" data-cell="flexor_tone_score_1" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '2') selected-score @endif" align="center" valign="middle">
                                <p>arm flexion <br> < <br> leg flexion</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('flexor_tone_score', '2.5', this)" data-cell="flexor_tone_score_2-5" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '2.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('flexor_tone_score', '3', this)" data-cell="flexor_tone_score_2" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '3') selected-score @endif">
                                <p>arm flexion <br> = <br> leg flexion</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('flexor_tone_score', '3.5', this)" data-cell="flexor_tone_score_3-5" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '3.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('flexor_tone_score', '4', this)" data-cell="flexor_tone_score_3" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '4') selected-score @endif">
                                <p>arm flexion <br> > <br> leg flexion: <br> difference &leq; 1 column</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('flexor_tone_score', '4.5', this)" data-cell="flexor_tone_score_4-5" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '4.5') selected-score @endif">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('flexor_tone_score', '5', this)" data-cell="flexor_tone_score_4" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '5') selected-score @endif">
                                <p>arm flexion <br> > <br> leg flexion: <br> difference > 1 column</p>
                            </td>
                            <td width="7%">
                                @php $hnne_details->flexor_tone_status = isset($hnne_details->flexor_tone_status) ? $hnne_details->flexor_tone_status : 1; @endphp
                                {{ Form::radio('flexor_tone_status', 1, ($hnne_details->flexor_tone_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('flexor_tone_status', 2, ($hnne_details->flexor_tone_status == 2 ? true : false)) }} Asymmetric                                
                                {!! Form::textarea('flexor_tone_asymmetric', @$hnne_details->flexor_tone_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'flexor_tone_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered flexor_tone_score_table">
                                    <tr>
                                        <td>1</td>
                                        <td>.5</td>
                                        <td>2</td>
                                        <td>.5</td>
                                        <td>3</td>
                                        <td>.5</td>
                                        <td>4</td>
                                        <td>.5</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td class="flexor_tone_score_valid_1_first_group">0</td>
                                        <td class="flexor_tone_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary flexor_tone_score_valid_2_first_group">45</td>
                                        <td class="bg-secondary flexor_tone_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary flexor_tone_score_valid_3_first_group">27</td>
                                        <td class="bg-secondary flexor_tone_score_valid_3-5_first_group"><1</td>
                                        <td class="bg-secondary flexor_tone_score_valid_4_first_group">27</td>
                                        <td class="flexor_tone_score_valid_4-5_first_group">0</td>
                                        <td class="flexor_tone_score_valid_5_first_group">1</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="flexor_tone_score_valid_1_second_group">0</td>
                                        <td class="flexor_tone_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary flexor_tone_score_valid_2_second_group">40</td>
                                        <td class="bg-secondary flexor_tone_score_valid_2-5_second_group"><1</td>
                                        <td class="bg-secondary flexor_tone_score_valid_3_second_group">40</td>
                                        <td class="bg-secondary flexor_tone_score_valid_3-5_second_group">0</td>
                                        <td class="bg-secondary flexor_tone_score_valid_4_second_group">20</td>
                                        <td class="flexor_tone_score_valid_4-5_second_group"><1</td>
                                        <td class="flexor_tone_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="flexor_tone_score_valid_1_third_group">0</td>
                                        <td class="flexor_tone_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary flexor_tone_score_valid_2_third_group">34</td>
                                        <td class="bg-secondary flexor_tone_score_valid_2-5_third_group"><1</td>
                                        <td class="bg-secondary flexor_tone_score_valid_3_third_group">47</td>
                                        <td class="bg-secondary flexor_tone_score_valid_3-5_third_group"><1</td>
                                        <td class="bg-secondary flexor_tone_score_valid_4_third_group">24</td>
                                        <td class="flexor_tone_score_valid_4-5_third_group">0</td>
                                        <td class="Flexor_tone_score_valid_5_third_group">1</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="flexor_tone_score_valid_1_fourth_group">0</td>
                                        <td class="flexor_tone_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary flexor_tone_score_valid_2_fourth_group">38</td>
                                        <td class="bg-secondary flexor_tone_score_valid_2-5_fourth_group"><1</td>
                                        <td class="bg-secondary flexor_tone_score_valid_3_fourth_group">36</td>
                                        <td class="bg-secondary flexor_tone_score_valid_3-5_fourth_group"><1</td>
                                        <td class="bg-secondary flexor_tone_score_valid_4_fourth_group">24</td>
                                        <td class="flexor_tone_score_valid_4-5_fourth_group"><1</td>
                                        <td class="flexor_tone_score_valid_5_fourth_group">2</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="flexor_tone_score_valid_1_term_group">0</td>
                                        <td class="flexor_tone_score_valid_1-5_term_group">0</td>
                                        <td class="bg-secondary flexor_tone_score_valid_2_term_group">25</td>
                                        <td class="bg-secondary flexor_tone_score_valid_2-5_term_group">3</td>
                                        <td class="bg-secondary flexor_tone_score_valid_3_term_group">53</td>
                                        <td class="bg-secondary flexor_tone_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary flexor_tone_score_valid_4_term_group">18</td>
                                        <td class="flexor_tone_score_valid_4-5_term_group">0</td>
                                        <td class="flexor_tone_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="resting-posture">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>FLEXOR TONE <br>( resting posture )</strong>
                                <input type="hidden" class="hnne_scores" name="flexor_tone_resting_posture_score" value="@if(isset($hnne_details->flexor_tone_resting_posture_score)){{ $hnne_details->flexor_tone_resting_posture_score }}@endif">
                                <input type="hidden" name="tone_pattern_items[]" id="flexor_tone_resting_posture_score">
                            </td>
                            <td width="14%"></td>
                            <td width="3%"></td>
                            <td width="14%"></td>
                            <td width="3%" onclick="updateHNNEScore('flexor_tone_resting_posture_score', '2.5', this)" data-cell="flexor_tone_resting_posture_score_2-5" class="flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('flexor_tone_resting_posture_score', '3', this)" data-cell="flexor_tone_resting_posture_score_2" class="flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '3') selected-score @endif">
                                <p>arms and <br> legs generally flexed</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('flexor_tone_resting_posture_score', '3.5', this)" data-cell="flexor_tone_resting_posture_score_3-5" class="flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('flexor_tone_resting_posture_score', '4', this)" data-cell="flexor_tone_resting_posture_score_3" class="flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '4') selected-score @endif">
                                <p>strong arm flexion with strong leg extension <i>intermittent</i></p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('flexor_tone_resting_posture_score', '4.5', this)" data-cell="flexor_tone_resting_posture_score_4-5" class="flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('flexor_tone_resting_posture_score', '5', this)" data-cell="flexor_tone_resting_posture_score_4" class="flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '5') selected-score @endif">
                                <p>strong arm flexion with strong leg extension <i>continuous</i></p>
                            </td>
                            <td width="7%">
                                @php $hnne_details->flexor_tone_resting_posture_status = isset($hnne_details->flexor_tone_resting_posture_status) ? $hnne_details->flexor_tone_resting_posture_status : 1; @endphp
                                {{ Form::radio('flexor_tone_resting_posture_status', 1, ($hnne_details->flexor_tone_resting_posture_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('flexor_tone_resting_posture_status', 2, ($hnne_details->flexor_tone_resting_posture_status == 2 ? true : false)) }} Asymmetric                                                                
                                {!! Form::textarea('flexor_tone_resting_asymmetric', @$hnne_details->flexor_tone_resting_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'flexor_tone_resting_posture_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered flexor_tone_resting_posture_score_table">
                                    <tr>
                                        <td class="flexor_tone_resting_posture_score_valid_1_first_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_1-5_first_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_2_first_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary flexor_tone_resting_posture_score_valid_3_first_group">99</td>
                                        <td class="flexor_tone_resting_posture_score_valid_3-5_first_group"><1</td>
                                        <td class="flexor_tone_resting_posture_score_valid_4_first_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_4-5_first_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_5_first_group">1</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="flexor_tone_resting_posture_score_valid_1_second_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_1-5_second_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_2_second_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_2-5_second_group">0</td>
                                        <td class="bg-secondary flexor_tone_resting_posture_score_valid_3_second_group">96</td>
                                        <td class="flexor_tone_resting_posture_score_valid_3-5_second_group"><1</td>
                                        <td class="flexor_tone_resting_posture_score_valid_4_second_group">3</td>
                                        <td class="flexor_tone_resting_posture_score_valid_4-5_second_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_5_second_group">1</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="flexor_tone_resting_posture_score_valid_1_third_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_1-5_third_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_2_third_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_2-5_third_group">0</td>
                                        <td class="bg-secondary flexor_tone_resting_posture_score_valid_3_third_group">96</td>
                                        <td class="flexor_tone_resting_posture_score_valid_3-5_third_group"><1</td>
                                        <td class="flexor_tone_resting_posture_score_valid_4_third_group">2</td>
                                        <td class="flexor_tone_resting_posture_score_valid_4-5_third_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_5_third_group">2</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="flexor_tone_resting_posture_score_valid_1_fourth_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_1-5_fourth_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_2_fourth_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary flexor_tone_resting_posture_score_valid_3_fourth_group">94</td>
                                        <td class="flexor_tone_resting_posture_score_valid_3-5_fourth_group"><1</td>
                                        <td class="flexor_tone_resting_posture_score_valid_4_fourth_group">2</td>
                                        <td class="flexor_tone_resting_posture_score_valid_4-5_fourth_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_5_fourth_group">4</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="flexor_tone_resting_posture_score_valid_1_term_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_1-5_term_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_2_term_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary flexor_tone_resting_posture_score_valid_3_term_group">99</td>
                                        <td class="flexor_tone_resting_posture_score_valid_3-5_term_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_4_term_group"><1</td>
                                        <td class="flexor_tone_resting_posture_score_valid_4-5_term_group">0</td>
                                        <td class="flexor_tone_resting_posture_score_valid_5_term_group"><1</td>
                                        <td><strong>Full Term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="leg-tone">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>LEG TONE <br>( leg traction and <br>popliteal angle )</strong>
                                <input type="hidden" class="hnne_scores" name="leg_tone_score" value="@if(isset($hnne_details->leg_tone_score)){{ $hnne_details->leg_tone_score }}@endif">
                                <input type="hidden" name="tone_pattern_items[]" id="leg_tone_score">
                            </td>
                            <td width="14%"></td>
                            <td width="3%" onclick="updateHNNEScore('leg_tone_score', '1.5', this)" data-cell="leg_tone_score_1-5" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('leg_tone_score', '2', this)" data-cell="leg_tone_score_2" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '2') selected-score @endif">
                                <p>leg traction > popliteal angle</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_tone_score', '2.5', this)" data-cell="leg_tone_score_2-5" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('leg_tone_score', '3', this)" data-cell="leg_tone_score_3" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '3') selected-score @endif">
                                <p>leg traction = popliteal angle</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_tone_score', '3.5', this)" data-cell="leg_tone_score_3-5" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('leg_tone_score', '4', this)" data-cell="leg_tone_score_4" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '4') selected-score @endif">
                                <p>leg traction < popliteal angle; <br>difference &leq;1 column</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('leg_tone_score', '4.5', this)" data-cell="leg_tone_score_4-5" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('leg_tone_score', '5', this)" data-cell="leg_tone_score_5" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '5') selected-score @endif">
                                <p>leg traction < popliteal angle; <br>difference >1 column</p>
                            </td>
                            <td width="7%">
                                @php $hnne_details->leg_tone_status = isset($hnne_details->leg_tone_status) ? $hnne_details->leg_tone_status : 1; @endphp
                                {{ Form::radio('leg_tone_status', 1, ($hnne_details->leg_tone_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('leg_tone_status', 2, ($hnne_details->leg_tone_status == 2 ? true : false)) }} Asymmetric                                                                
                                {!! Form::textarea('leg_tone_asymmetric', @$hnne_details->leg_tone_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'leg_tone_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered leg_tone_score_table">
                                    <tr>
                                        <td class="leg_tone_score_valid_1_first_group">0</td>
                                        <td class="leg_tone_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary leg_tone_score_valid_2_first_group">43</td>
                                        <td class="bg-secondary leg_tone_score_valid_2-5_first_group"><1</td>
                                        <td class="bg-secondary leg_tone_score_valid_3_first_group">34</td>
                                        <td class="bg-secondary leg_tone_score_valid_3-5_first_group">0</td>
                                        <td class="bg-secondary leg_tone_score_valid_4_first_group">21</td>
                                        <td class="leg_tone_score_valid_4-5_first_group"><1</td>
                                        <td class="leg_tone_score_valid_5_first_group">1</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_tone_score_valid_1_second_group">0</td>
                                        <td class="leg_tone_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary leg_tone_score_valid_2_second_group">41</td>
                                        <td class="bg-secondary leg_tone_score_valid_2-5_second_group">0</td>
                                        <td class="bg-secondary leg_tone_score_valid_3_second_group">39</td>
                                        <td class="bg-secondary leg_tone_score_valid_3-5_second_group"><1</td>
                                        <td class="bg-secondary leg_tone_score_valid_4_second_group">19</td>
                                        <td class="leg_tone_score_valid_4-5_second_group">0</td>
                                        <td class="leg_tone_score_valid_5_second_group">1</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_tone_score_valid_1_third_group">0</td>
                                        <td class="leg_tone_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary leg_tone_score_valid_2_third_group">38</td>
                                        <td class="bg-secondary leg_tone_score_valid_2-5_third_group">0</td>
                                        <td class="bg-secondary leg_tone_score_valid_3_third_group">36</td>
                                        <td class="bg-secondary leg_tone_score_valid_3-5_third_group"><1</td>
                                        <td class="bg-secondary leg_tone_score_valid_4_third_group">22</td>
                                        <td class="leg_tone_score_valid_4-5_third_group"><1</td>
                                        <td class="leg_tone_score_valid_5_third_group">4</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_tone_score_valid_1_fourth_group">0</td>
                                        <td class="leg_tone_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary leg_tone_score_valid_2_fourth_group">19</td>
                                        <td class="bg-secondary leg_tone_score_valid_2-5_fourth_group"><1</td>
                                        <td class="bg-secondary leg_tone_score_valid_3_fourth_group">50</td>
                                        <td class="bg-secondary leg_tone_score_valid_3-5_fourth_group"><1</td>
                                        <td class="bg-secondary leg_tone_score_valid_4_fourth_group">29</td>
                                        <td class="leg_tone_score_valid_4-5_fourth_group"><1</td>
                                        <td class="leg_tone_score_valid_5_fourth_group">2</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="leg_tone_score_valid_1_term_group">0</td>
                                        <td class="leg_tone_score_valid_1-5_term_group">0</td>
                                        <td class="leg_tone_score_valid_2_term_group">4</td>
                                        <td class="leg_tone_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary leg_tone_score_valid_3_term_group">57</td>
                                        <td class="bg-secondary leg_tone_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary leg_tone_score_valid_4_term_group">35</td>
                                        <td class="leg_tone_score_valid_4-5_term_group">0</td>
                                        <td class="leg_tone_score_valid_5_term_group">1</td>
                                        <td><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="head-control-sitting">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>HEAD CONTROL <br>( sitting )</strong>
                                <input type="hidden" class="hnne_scores" name="head_control_sitting_score" value="@if(isset($hnne_details->head_control_sitting_score)){{ $hnne_details->head_control_sitting_score }}@endif">
                                <input type="hidden" name="tone_pattern_items[]" id="head_control_sitting_score">
                            </td>
                            <td width="14%"></td>
                            <td width="3%" onclick="updateHNNEScore('head_control_sitting_score', '1.5', this)" data-cell="head_control_sitting_score_1-5" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('head_control_sitting_score', '2', this)" data-cell="head_control_sitting_score_2" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '2') selected-score @endif">
                                <p>neck extension < neck flexion</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_sitting_score', '2.5', this)" data-cell="head_control_sitting_score_2-5" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('head_control_sitting_score', '3', this)" data-cell="head_control_sitting_score_3" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '3') selected-score @endif">
                                <p>neck extension = neck flexion</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_sitting_score', '3.5', this)" data-cell="head_control_sitting_score_3-5" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('head_control_sitting_score', '4', this)" data-cell="head_control_sitting_score_4" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '4') selected-score @endif">
                                <p>neck extension > neck flexion <br>difference &leq; 1 column</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_control_sitting_score', '4.5', this)" data-cell="head_control_sitting_score_4-5" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('head_control_sitting_score', '5', this)" data-cell="head_control_sitting_score_5" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '5') selected-score @endif">
                                <p>neck extension > neck flexion <br>difference > 1 column</p>
                            </td>
                            <td width="7%">
                                @php $hnne_details->head_control_sitting_status = isset($hnne_details->head_control_sitting_status) ? $hnne_details->head_control_sitting_status : 1; @endphp
                                {{ Form::radio('head_control_sitting_status', 1, ($hnne_details->head_control_sitting_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('head_control_sitting_status', 2, ($hnne_details->head_control_sitting_status == 2 ? true : false)) }} Asymmetric                                                                
                                {!! Form::textarea('head_control_sitting_asymmetric', @$hnne_details->head_control_sitting_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'head_control_sitting_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered head_control_sitting_score_table">
                                    <tr>
                                        <td class="head_control_sitting_score_valid_1_first_group">0</td>
                                        <td class="head_control_sitting_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_2_first_group">25</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_3_first_group">64</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_3-5_first_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_4_first_group">29</td>
                                        <td class="head_control_sitting_score_valid_4-5_first_group">0</td>
                                        <td class="head_control_sitting_score_valid_5_first_group">2</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_sitting_score_valid_1_second_group">0</td>
                                        <td class="head_control_sitting_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_2_second_group">17</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_2-5_second_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_3_second_group">70</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_3-5_second_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_4_second_group">13</td>
                                        <td class="head_control_sitting_score_valid_4-5_second_group">0</td>
                                        <td class="head_control_sitting_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_sitting_score_valid_1_third_group">0</td>
                                        <td class="head_control_sitting_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_2_third_group">18</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_2-5_third_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_3_third_group">76</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_3-5_third_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_4_third_group">6</td>
                                        <td class="head_control_sitting_score_valid_4-5_third_group">0</td>
                                        <td class="head_control_sitting_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_sitting_score_valid_1_fourth_group">0</td>
                                        <td class="head_control_sitting_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_2_fourth_group">23</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_3_fourth_group">64</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_3-5_fourth_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_4_fourth_group">13</td>
                                        <td class="head_control_sitting_score_valid_4-5_fourth_group">0</td>
                                        <td class="head_control_sitting_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_control_sitting_score_valid_1_term_group">0</td>
                                        <td class="head_control_sitting_score_valid_1-5_term_group">0</td>
                                        <td class="head_control_sitting_score_valid_2_term_group">3</td>
                                        <td class="head_control_sitting_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary head_control_sitting_score_valid_3_term_group">94</td>
                                        <td class="head_control_sitting_score_valid_3-5_term_group">0</td>
                                        <td class="head_control_sitting_score_valid_4_term_group">3</td>
                                        <td class="head_control_sitting_score_valid_4-5_term_group">0</td>
                                        <td class="head_control_sitting_score_valid_5_term_group"><1</td>
                                        <td><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="neck-axial-tone">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>NECK AND <br>AXIAL TONE <br>( horizontal )</strong>
                                <input type="hidden" class="hnne_scores" name="neck_axial_tone_score" value="@if(isset($hnne_details->neck_axial_tone_score)){{ $hnne_details->neck_axial_tone_score }}@endif">
                                <input type="hidden" name="tone_pattern_items[]" id="neck_axial_tone_score">
                            </td>
                            <td width="14%"></td>
                            <td width="3%" onclick="updateHNNEScore('neck_axial_tone_score', '1.5', this)" data-cell="neck_axial_tone_score_1-5" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('neck_axial_tone_score', '2', this)" data-cell="neck_axial_tone_score_2" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '2') selected-score @endif">
                                <p>ventral suspension < head lag</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('neck_axial_tone_score', '2.5', this)" data-cell="neck_axial_tone_score_2-5" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('neck_axial_tone_score', '3', this)" data-cell="neck_axial_tone_score_3" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '3') selected-score @endif">
                                <p>ventral suspension = head lag</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('neck_axial_tone_score', '3.5', this)" data-cell="neck_axial_tone_score_3-5" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('neck_axial_tone_score', '4', this)" data-cell="neck_axial_tone_score_4" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '4') selected-score @endif">
                                <p>ventral suspension > head lag <br>difference &leq; 1 column</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('neck_axial_tone_score', '4.5', this)" data-cell="neck_axial_tone_score_4-5" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('neck_axial_tone_score', '5', this)" data-cell="neck_axial_tone_score_5" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '5') selected-score @endif">
                                <p>ventral suspension > head lag <br>difference > 1 column</p>
                            </td>
                            <td width="7%">
                                @php $hnne_details->neck_axial_tone_status = isset($hnne_details->neck_axial_tone_status) ? $hnne_details->neck_axial_tone_status : 1; @endphp
                                {{ Form::radio('neck_axial_tone_status', 1, ($hnne_details->neck_axial_tone_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('neck_axial_tone_status', 2, ($hnne_details->neck_axial_tone_status == 2 ? true : false)) }} Asymmetric                                                                
                                {!! Form::textarea('neck_axial_tone_asymmetric', @$hnne_details->neck_axial_tone_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'neck_axial_tone_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered neck_axial_tone_score_table">
                                    <tr>
                                        <td class="neck_axial_tone_score_valid_1_first_group">0</td>
                                        <td class="neck_axial_tone_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_2_first_group">20</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_3_first_group">39</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_3-5_first_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_4_first_group">35</td>
                                        <td class="neck_axial_tone_score_valid_4-5_first_group">0</td>
                                        <td class="neck_axial_tone_score_valid_5_first_group">6</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="neck_axial_tone_score_valid_1_second_group">0</td>
                                        <td class="neck_axial_tone_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_2_second_group">31</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_2-5_second_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_3_second_group">42</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_3-5_second_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_4_second_group">26</td>
                                        <td class="neck_axial_tone_score_valid_4-5_second_group">0</td>
                                        <td class="neck_axial_tone_score_valid_5_second_group">1</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="neck_axial_tone_score_valid_1_third_group">0</td>
                                        <td class="neck_axial_tone_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_2_third_group">24</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_2-5_third_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_3_third_group">49</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_3-5_third_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_4_third_group">26</td>
                                        <td class="neck_axial_tone_score_valid_4-5_third_group">0</td>
                                        <td class="neck_axial_tone_score_valid_5_third_group">1</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="neck_axial_tone_score_valid_1_fourth_group">0</td>
                                        <td class="neck_axial_tone_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_2_fourth_group">17</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_3_fourth_group">51</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_3-5_fourth_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_4_fourth_group">28</td>
                                        <td class="neck_axial_tone_score_valid_4-5_fourth_group">0</td>
                                        <td class="neck_axial_tone_score_valid_5_fourth_group">4</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="neck_axial_tone_score_valid_1_term_group">0</td>
                                        <td class="neck_axial_tone_score_valid_1-5_term_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_2_term_group">24</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_3_term_group">58</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary neck_axial_tone_score_valid_4_term_group">18</td>
                                        <td class="neck_axial_tone_score_valid_4-5_term_group">0</td>
                                        <td class="neck_axial_tone_score_valid_5_term_group"><1</td>
                                        <td><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hnnescreening3">
        <div class="row hnne-container">
            <div class="table-responsive">
                <h3><strong>Reflex items</strong></h3>
                <table class="table valign-middle">
                    <tbody>
                        <tr class="tendon-reflex">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>TENDON REFLEX</strong>
                                <input type="hidden" class="hnne_scores" name="tendon_reflex_score" value="@if(isset($hnne_details->tendon_reflex_score)){{ $hnne_details->tendon_reflex_score }}@endif">
                                <input type="hidden" name="reflex_items[]" id="tendon_reflex_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('tendon_reflex_score', '1', this)" data-cell="tendon_reflex_score_1" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>absent</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('tendon_reflex_score', '1.5', this)" data-cell="tendon_reflex_score_1-5" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('tendon_reflex_score', '2', this)" data-cell="tendon_reflex_score_2" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '2') selected-score @endif">
                                <p>felt, not seen</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('tendon_reflex_score', '2.5', this)" data-cell="tendon_reflex_score_2-5" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('tendon_reflex_score', '3', this)" data-cell="tendon_reflex_score_3" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '3') selected-score @endif">
                                <p>seen</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('tendon_reflex_score', '3.5', this)" data-cell="tendon_reflex_score_3-5" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('tendon_reflex_score', '4', this)" data-cell="tendon_reflex_score_4" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '4') selected-score @endif">
                                <p>'exaggerated'</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('tendon_reflex_score', '4.5', this)" data-cell="tendon_reflex_score_4-5" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('tendon_reflex_score', '5', this)" data-cell="tendon_reflex_score_5" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '5') selected-score @endif">
                                <p>clonus</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->tendon_reflex_status = isset($hnne_details->tendon_reflex_status) ? $hnne_details->tendon_reflex_status : 1; @endphp
                                {{ Form::radio('tendon_reflex_status', 1, ($hnne_details->tendon_reflex_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('tendon_reflex_status', 2, ($hnne_details->tendon_reflex_status == 2 ? true : false)) }} Asymmetric                                                                
                                {!! Form::textarea('tendon_reflex_asymmetric', @$hnne_details->tendon_reflex_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'tendon_reflex_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered tendon_reflex_score_table">
                                    <tr>
                                        <td>1</td>
                                        <td>.5</td>
                                        <td>2</td>
                                        <td>.5</td>
                                        <td>3</td>
                                        <td>.5</td>
                                        <td>4</td>
                                        <td>.5</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td class="tendon_reflex_score_valid_1_first_group">0</td>
                                        <td class="tendon_reflex_score_valid_1-5_first_group">0</td>
                                        <td class="tendon_reflex_score_valid_2_first_group">9</td>
                                        <td class="tendon_reflex_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_3_first_group">55</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_3-5_first_group">7</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_4_first_group">13</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_4-5_first_group">3</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_5_first_group">13</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tendon_reflex_score_valid_1_second_group">0</td>
                                        <td class="tendon_reflex_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_2_second_group">12</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_2-5_second_group">0</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_3_second_group">50</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_3-5_second_group">7</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_4_second_group">22</td>
                                        <td class="tendon_reflex_score_valid_4-5_second_group">4</td>
                                        <td class="tendon_reflex_score_valid_5_second_group">5</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tendon_reflex_score_valid_1_third_group">0</td>
                                        <td class="tendon_reflex_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_2_third_group">24</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_2-5_third_group">1</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_3_third_group">52</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_3-5_third_group">1</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_4_third_group">13</td>
                                        <td class="tendon_reflex_score_valid_4-5_third_group">0</td>
                                        <td class="tendon_reflex_score_valid_5_third_group">9</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tendon_reflex_score_valid_1_fourth_group">0</td>
                                        <td class="tendon_reflex_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_2_fourth_group">18</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_3_fourth_group">57</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_3-5_fourth_group">0</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_4_fourth_group">17</td>
                                        <td class="tendon_reflex_score_valid_4-5_fourth_group">4</td>
                                        <td class="tendon_reflex_score_valid_5_fourth_group">4</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tendon_reflex_score_valid_1_term_group"><1</td>
                                        <td class="tendon_reflex_score_valid_1-5_term_group">0</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_2_term_group">21</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_3_term_group">78</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary tendon_reflex_score_valid_4_term_group"><1</td>
                                        <td class="tendon_reflex_score_valid_4-5_term_group">0</td>
                                        <td class="tendon_reflex_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="suck-gag">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>SUCK / GAG</strong>
                                <input type="hidden" class="hnne_scores" name="suck_gag_score" value="@if(isset($hnne_details->suck_gag_score)){{ $hnne_details->suck_gag_score }}@endif">
                                <input type="hidden" name="reflex_items[]" id="suck_gag_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('suck_gag_score', '1', this)" data-cell="suck_gag_score_1" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>no gag / no suck</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('suck_gag_score', '1.5', this)" data-cell="suck_gag_score_1-5" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('suck_gag_score', '2', this)" data-cell="suck_gag_score_2" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '2') selected-score @endif">
                                <p>weak irregular suck only:</p>
                                <p>no stripping</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('suck_gag_score', '2.5', this)" data-cell="suck_gag_score_2-5" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('suck_gag_score', '3', this)" data-cell="suck_gag_score_3" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '3') selected-score @endif">
                                <p>weak regular suck </p>
                                <p>some stripping</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('suck_gag_score', '3.5', this)" data-cell="suck_gag_score_3-5" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('suck_gag_score', '4', this)" data-cell="suck_gag_score_4" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '4') selected-score @endif">
                                <p>strong suck <br>(a) irregular <br>(b) regular</p>
                                <p>good stripping</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('suck_gag_score', '4.5', this)" data-cell="suck_gag_score_4-5" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('suck_gag_score', '5', this)" data-cell="suck_gag_score_5" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '5') selected-score @endif">
                                <p>no suck but strong clenching</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->suck_gag_status = isset($hnne_details->suck_gag_status) ? $hnne_details->suck_gag_status : 1; @endphp
                                {{ Form::radio('suck_gag_status', 1, ($hnne_details->suck_gag_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('suck_gag_status', 2, ($hnne_details->suck_gag_status == 2 ? true : false)) }} Asymmetric                                                                
                                {!! Form::textarea('suck_gag_asymmetric', @$hnne_details->suck_gag_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'suck_gag_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered suck_gag_score_table">
                                    <tr>
                                        <td class="suck_gag_score_valid_1_first_group">0</td>
                                        <td class="suck_gag_score_valid_1-5_first_group">0</td>
                                        <td class="suck_gag_score_valid_2_first_group">1</td>
                                        <td class="suck_gag_score_valid_2-5_first_group">0</td>
                                        <td class="suck_gag_score_valid_3_first_group">3</td>
                                        <td class="suck_gag_score_valid_3-5_first_group">3</td>
                                        <td class="bg-secondary suck_gag_score_valid_4_first_group">93</td>
                                        <td class="suck_gag_score_valid_4-5_first_group">0</td>
                                        <td class="suck_gag_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="suck_gag_score_valid_1_second_group">0</td>
                                        <td class="suck_gag_score_valid_1-5_second_group">0</td>
                                        <td class="suck_gag_score_valid_2_second_group">3</td>
                                        <td class="suck_gag_score_valid_2-5_second_group">0</td>
                                        <td class="suck_gag_score_valid_3_second_group">7</td>
                                        <td class="suck_gag_score_valid_3-5_second_group">0</td>
                                        <td class="bg-secondary suck_gag_score_valid_4_second_group">90</td>
                                        <td class="suck_gag_score_valid_4-5_second_group">0</td>
                                        <td class="suck_gag_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="suck_gag_score_valid_1_third_group">0</td>
                                        <td class="suck_gag_score_valid_1-5_third_group">0</td>
                                        <td class="suck_gag_score_valid_2_third_group">0</td>
                                        <td class="suck_gag_score_valid_2-5_third_group">0</td>
                                        <td class="suck_gag_score_valid_3_third_group">6</td>
                                        <td class="suck_gag_score_valid_3-5_third_group">2</td>
                                        <td class="bg-secondary suck_gag_score_valid_4_third_group">92</td>
                                        <td class="suck_gag_score_valid_4-5_third_group">0</td>
                                        <td class="suck_gag_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="suck_gag_score_valid_1_fourth_group">0</td>
                                        <td class="suck_gag_score_valid_1-5_fourth_group">0</td>
                                        <td class="suck_gag_score_valid_2_fourth_group">4</td>
                                        <td class="suck_gag_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary suck_gag_score_valid_3_fourth_group">10</td>
                                        <td class="bg-secondary suck_gag_score_valid_3-5_fourth_group">0</td>
                                        <td class="bg-secondary suck_gag_score_valid_4_fourth_group">86</td>
                                        <td class="suck_gag_score_valid_4-5_fourth_group">0</td>
                                        <td class="suck_gag_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="suck_gag_score_valid_1_term_group">0</td>
                                        <td class="suck_gag_score_valid_1-5_term_group">0</td>
                                        <td class="suck_gag_score_valid_2_term_group">1</td>
                                        <td class="suck_gag_score_valid_2-5_term_group">0</td>
                                        <td class="suck_gag_score_valid_3_term_group">5</td>
                                        <td class="suck_gag_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary suck_gag_score_valid_4_term_group">92</td>
                                        <td class="suck_gag_score_valid_4-5_term_group">0</td>
                                        <td class="suck_gag_score_valid_5_term_group">2</td>
                                        <td><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="palmar-grasp">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>PALMAR <br>GRASP</strong>
                                <input type="hidden" class="hnne_scores" name="palmar_grasp_score" value="@if(isset($hnne_details->palmar_grasp_score)){{ $hnne_details->palmar_grasp_score }}@endif">
                                <input type="hidden" name="reflex_items[]" id="palmar_grasp_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('palmar_grasp_score', '1', this)" data-cell="palmar_grasp_score_1" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>no response</p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('palmar_grasp_score', '1.5', this)" data-cell="palmar_grasp_score_1-5" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('palmar_grasp_score', '2', this)" data-cell="palmar_grasp_score_2" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '2') selected-score @endif">
                                <p>short weak flexion fingers</p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('palmar_grasp_score', '2.5', this)" data-cell="palmar_grasp_score_2-5" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('palmar_grasp_score', '3', this)" data-cell="palmar_grasp_score_3" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '3') selected-score @endif">
                                <p>strong flexion of fingers</p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('palmar_grasp_score', '3.5', this)" data-cell="palmar_grasp_score_3-5" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('palmar_grasp_score', '4', this)" data-cell="palmar_grasp_score_4" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '4') selected-score @endif">
                                <p>very strong flexion fingers, shoulder <span style="font-size: 20px">&#8593;</span></p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('palmar_grasp_score', '4.5', this)" data-cell="palmar_grasp_score_4-5" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('palmar_grasp_score', '5', this)" data-cell="palmar_grasp_score_5" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '5') selected-score @endif">
                                <p>very strong grasp; infant can be lifted off couch</p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->palmar_grasp_status = isset($hnne_details->palmar_grasp_status) ? $hnne_details->palmar_grasp_status : 1; @endphp
                                {{ Form::radio('palmar_grasp_status', 1, ($hnne_details->palmar_grasp_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('palmar_grasp_status', 2, ($hnne_details->palmar_grasp_status == 2 ? true : false)) }} Asymmetric                                                                                            
                                {!! Form::textarea('palmar_grasp_asymmetric', @$hnne_details->palmar_grasp_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'palmar_grasp_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered palmar_grasp_score_table">
                                    <tr>
                                        <td class="palmar_grasp_score_valid_1_first_group">0</td>
                                        <td class="palmar_grasp_score_valid_1-5_first_group">0</td>
                                        <td class="palmar_grasp_score_valid_2_first_group">5</td>
                                        <td class="palmar_grasp_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_3_first_group">47</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_3-5_first_group">7</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_4_first_group">30</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_4-5_first_group">1</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_5_first_group">10</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="palmar_grasp_score_valid_1_second_group">0</td>
                                        <td class="palmar_grasp_score_valid_1-5_second_group">0</td>
                                        <td class="palmar_grasp_score_valid_2_second_group">3</td>
                                        <td class="palmar_grasp_score_valid_2-5_second_group">1</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_3_second_group">40</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_3-5_second_group">8</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_4_second_group">43</td>
                                        <td class="palmar_grasp_score_valid_4-5_second_group">1</td>
                                        <td class="palmar_grasp_score_valid_5_second_group">4</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="palmar_grasp_score_valid_1_third_group">0</td>
                                        <td class="palmar_grasp_score_valid_1-5_third_group">0</td>
                                        <td class="palmar_grasp_score_valid_2_third_group">1</td>
                                        <td class="palmar_grasp_score_valid_2-5_third_group">0</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_3_third_group">51</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_3-5_third_group">3</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_4_third_group">35</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_4-5_third_group">1</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_5_third_group">10</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="palmar_grasp_score_valid_1_fourth_group">0</td>
                                        <td class="palmar_grasp_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_2_fourth_group">7</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_3_fourth_group">53</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_3-5_fourth_group">3</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_4_fourth_group">30</td>
                                        <td class="palmar_grasp_score_valid_4-5_fourth_group">0</td>
                                        <td class="palmar_grasp_score_valid_5_fourth_group">7</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="palmar_grasp_score_valid_1_term_group"><1</td>
                                        <td class="palmar_grasp_score_valid_1-5_term_group">0</td>
                                        <td class="palmar_grasp_score_valid_2_term_group">6</td>
                                        <td class="palmar_grasp_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_3_term_group">84</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary palmar_grasp_score_valid_4_term_group">9</td>
                                        <td class="palmar_grasp_score_valid_4-5_term_group">0</td>
                                        <td class="palmar_grasp_score_valid_5_term_group"><1</td>
                                        <td><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="plantar-grasp">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>PLANTAR <br>GRASP</strong>
                                <input type="hidden" class="hnne_scores" name="plantar_grasp_score" value="@if(isset($hnne_details->plantar_grasp_score)){{ $hnne_details->plantar_grasp_score }}@endif">
                                <input type="hidden" name="reflex_items[]" id="plantar_grasp_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('plantar_grasp_score', '1', this)" data-cell="plantar_grasp_score_1" class="plantar_grasp_score_field @if(isset($hnne_details->plantar_grasp_score) && $hnne_details->plantar_grasp_score == '1') selected-score @endif " align="center" valign="middle">
                                <p>no response</p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('plantar_grasp_score', '1.5', this)" data-cell="plantar_grasp_score_1-5" class="plantar_grasp_score_field @if(isset($hnne_details->plantar_grasp_score) && $hnne_details->plantar_grasp_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('plantar_grasp_score', '2', this)" data-cell="plantar_grasp_score_2" class="plantar_grasp_score_field @if(isset($hnne_details->plantar_grasp_score) && $hnne_details->plantar_grasp_score == '2') selected-score @endif ">
                                <p>partial plantat flexion of toes</p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('plantar_grasp_score', '2.5', this)" data-cell="plantar_grasp_score_2-5" class="plantar_grasp_score_field @if(isset($hnne_details->plantar_grasp_score) && $hnne_details->plantar_grasp_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('plantar_grasp_score', '3', this)" data-cell="plantar_grasp_score_3" class="plantar_grasp_score_field @if(isset($hnne_details->plantar_grasp_score) && $hnne_details->plantar_grasp_score == '3') selected-score @endif ">
                                <p>toes curve around the examiner's finger</p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="3%"></td>
                            <td width="14%"></td>
                            <td width="3%"></td>
                            <td width="14%"></td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->plantar_grasp_status = isset($hnne_details->plantar_grasp_status) ? $hnne_details->plantar_grasp_status : 1; @endphp
                                {{ Form::radio('plantar_grasp_status', 1, ($hnne_details->plantar_grasp_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('plantar_grasp_status', 2, ($hnne_details->plantar_grasp_status == 2 ? true : false)) }} Asymmetric                                
                                {!! Form::textarea('plantar_grasp_asymmetric', @$hnne_details->plantar_grasp_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'plantar_grasp_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered plantar_grasp_score_table">
                                    <tr>
                                        <td class="plantar_grasp_score_valid_1_first_group">0</td>
                                        <td class="plantar_grasp_score_valid_1-5_first_group">0</td>
                                        <td class="plantar_grasp_score_valid_2_first_group">4</td>
                                        <td class="plantar_grasp_score_valid_2-5_first_group">1</td>
                                        <td class="bg-secondary plantar_grasp_score_valid_3_first_group">95</td>
                                        <td class="plantar_grasp_score_valid_3-5_first_group">0</td>
                                        <td class="plantar_grasp_score_valid_4_first_group">0</td>
                                        <td class="plantar_grasp_score_valid_4-5_first_group">0</td>
                                        <td class="plantar_grasp_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="plantar_grasp_score_valid_1_second_group">0</td>
                                        <td class="plantar_grasp_score_valid_1-5_second_group">1</td>
                                        <td class="plantar_grasp_score_valid_2_second_group">5</td>
                                        <td class="plantar_grasp_score_valid_2-5_second_group">2</td>
                                        <td class="bg-secondary plantar_grasp_score_valid_3_second_group">92</td>
                                        <td class="plantar_grasp_score_valid_3-5_second_group">0</td>
                                        <td class="plantar_grasp_score_valid_4_second_group">0</td>
                                        <td class="plantar_grasp_score_valid_4-5_second_group">0</td>
                                        <td class="plantar_grasp_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="plantar_grasp_score_valid_1_third_group">0</td>
                                        <td class="plantar_grasp_score_valid_1-5_third_group">0</td>
                                        <td class="plantar_grasp_score_valid_2_third_group">2</td>
                                        <td class="plantar_grasp_score_valid_2-5_third_group">1</td>
                                        <td class="bg-secondary plantar_grasp_score_valid_3_third_group">97</td>
                                        <td class="plantar_grasp_score_valid_3-5_third_group">0</td>
                                        <td class="plantar_grasp_score_valid_4_third_group">0</td>
                                        <td class="plantar_grasp_score_valid_4-5_third_group">0</td>
                                        <td class="plantar_grasp_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="plantar_grasp_score_valid_1_fourth_group">0</td>
                                        <td class="plantar_grasp_score_valid_1-5_fourth_group">0</td>
                                        <td class="plantar_grasp_score_valid_2_fourth_group">2</td>
                                        <td class="plantar_grasp_score_valid_2-5_fourth_group">2</td>
                                        <td class="bg-secondary plantar_grasp_score_valid_3_fourth_group">96</td>
                                        <td class="plantar_grasp_score_valid_3-5_fourth_group">0</td>
                                        <td class="plantar_grasp_score_valid_4_fourth_group">0</td>
                                        <td class="plantar_grasp_score_valid_4-5_fourth_group">0</td>
                                        <td class="plantar_grasp_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="plantar_grasp_score_valid_1_term_group"><1</td>
                                        <td class="plantar_grasp_score_valid_1-5_term_group">0</td>
                                        <td class="plantar_grasp_score_valid_2_term_group">2</td>
                                        <td class="plantar_grasp_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary plantar_grasp_score_valid_3_term_group">98</td>
                                        <td class="plantar_grasp_score_valid_3-5_term_group">0</td>
                                        <td class="plantar_grasp_score_valid_4_term_group">0</td>
                                        <td class="plantar_grasp_score_valid_4-5_term_group">0</td>
                                        <td class="plantar_grasp_score_valid_5_term_group">0</td>
                                        <td><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="placing">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>PLACING</strong>
                                <input type="hidden" class="hnne_scores" name="placing_score" value="@if(isset($hnne_details->placing_score)){{ $hnne_details->placing_score }}@endif">
                                <input type="hidden" name="reflex_items[]" id="placing_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('placing_score', '1', this)" data-cell="placing_score_1" class="placing_score_field @if(isset($hnne_details->placing_score) && $hnne_details->placing_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>no response</p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('placing_score', '1.5', this)" data-cell="placing_score_1-5" class="placing_score_field @if(isset($hnne_details->placing_score) && $hnne_details->placing_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('placing_score', '2', this)" data-cell="placing_score_2" class="placing_score_field @if(isset($hnne_details->placing_score) && $hnne_details->placing_score == '2') selected-score @endif">
                                <p>dorsi flexion of ankle only</p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('placing_score', '2.5', this)" data-cell="placing_score_2-5" class="placing_score_field @if(isset($hnne_details->placing_score) && $hnne_details->placing_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('placing_score', '3', this)" data-cell="placing_score_3" class="placing_score_field @if(isset($hnne_details->placing_score) && $hnne_details->placing_score == '3') selected-score @endif">
                                <p>full placing response with flexion of hip, knee & placing sole on surface</p>
                                <br>
                                <div>
                                    <span class="pull-left">R</span>
                                    <span class="pull-right">L</span>
                                </div>
                            </td>
                            <td width="3%"></td>
                            <td width="14%"></td>
                            <td width="3%"></td>
                            <td width="14%"></td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->placing_status = isset($hnne_details->placing_status) ? $hnne_details->placing_status : 1; @endphp
                                {{ Form::radio('placing_status', 1, ($hnne_details->placing_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('placing_status', 2, ($hnne_details->placing_status == 2 ? true : false)) }} Asymmetric                            
                                {!! Form::textarea('placing_asymmetric', @$hnne_details->placing_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'placing_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered placing_score_table">
                                    <tr>
                                        <td class="placing_score_valid_1_first_group">5</td>
                                        <td class="placing_score_valid_1-5_first_group">2</td>
                                        <td class="bg-secondary placing_score_valid_2_first_group">12</td>
                                        <td class="bg-secondary placing_score_valid_2-5_first_group">3</td>
                                        <td class="bg-secondary placing_score_valid_3_first_group">78</td>
                                        <td class="placing_score_valid_3-5_first_group">0</td>
                                        <td class="placing_score_valid_4_first_group">0</td>
                                        <td class="placing_score_valid_4-5_first_group">0</td>
                                        <td class="placing_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="placing_score_valid_1_second_group">0</td>
                                        <td class="placing_score_valid_1-5_second_group">2</td>
                                        <td class="bg-secondary placing_score_valid_2_second_group">12</td>
                                        <td class="bg-secondary placing_score_valid_2-5_second_group">6</td>
                                        <td class="bg-secondary placing_score_valid_3_second_group">80</td>
                                        <td class="placing_score_valid_3-5_second_group">0</td>
                                        <td class="placing_score_valid_4_second_group">0</td>
                                        <td class="placing_score_valid_4-5_second_group">0</td>
                                        <td class="placing_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="placing_score_valid_1_third_group">1</td>
                                        <td class="placing_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary placing_score_valid_2_third_group">8</td>
                                        <td class="bg-secondary placing_score_valid_2-5_third_group">8</td>
                                        <td class="bg-secondary placing_score_valid_3_third_group">83</td>
                                        <td class="placing_score_valid_3-5_third_group">0</td>
                                        <td class="placing_score_valid_4_third_group">0</td>
                                        <td class="placing_score_valid_4-5_third_group">0</td>
                                        <td class="placing_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="placing_score_valid_1_fourth_group">0</td>
                                        <td class="placing_score_valid_1-5_fourth_group">0</td>
                                        <td class="placing_score_valid_2_fourth_group">4</td>
                                        <td class="placing_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary placing_score_valid_3_fourth_group">96</td>
                                        <td class="placing_score_valid_3-5_fourth_group">0</td>
                                        <td class="placing_score_valid_4_fourth_group">0</td>
                                        <td class="placing_score_valid_4-5_fourth_group">0</td>
                                        <td class="placing_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="placing_score_valid_1_term_group">1</td>
                                        <td class="placing_score_valid_1-5_term_group">0</td>
                                        <td class="bg-secondary placing_score_valid_2_term_group">18</td>
                                        <td class="bg-secondary placing_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary placing_score_valid_3_term_group">81</td>
                                        <td class="placing_score_valid_3-5_term_group">0</td>
                                        <td class="placing_score_valid_4_term_group">0</td>
                                        <td class="placing_score_valid_4-5_term_group">0</td>
                                        <td class="placing_score_valid_5_term_group">0</td>
                                        <td><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="moro-reflex">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>MORO REFLEX</strong>
                                <input type="hidden" class="hnne_scores" name="moro_reflex_score" value="@if(isset($hnne_details->moro_reflex_score)){{ $hnne_details->moro_reflex_score }}@endif">
                                <input type="hidden" name="reflex_items[]" id="moro_reflex_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('moro_reflex_score', '1', this)" data-cell="moro_reflex_score_1" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '1') selected-score @endif" align="center">
                                <p>no response or opening of hands only</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('moro_reflex_score', '1.5', this)" data-cell="moro_reflex_score_1-5" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('moro_reflex_score', '2', this)" data-cell="moro_reflex_score_2" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '2') selected-score @endif" style="vertical-align: top !important;">
                                <p>full abduction at shoulder and extension of the arms: no adduction</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/moro-reflex-2.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('moro_reflex_score', '2.5', this)" data-cell="moro_reflex_score_2-5" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('moro_reflex_score', '3', this)" data-cell="moro_reflex_score_3" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '3') selected-score @endif" style="vertical-align: top !important;">
                                <p>full abduction but only delayed or partial adduction</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/moro-reflex-3.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('moro_reflex_score', '3.5', this)" data-cell="moro_reflex_score_3-5" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('moro_reflex_score', '4', this)" data-cell="moro_reflex_score_4" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '4') selected-score @endif" style="vertical-align: top !important;">
                                <p>partial abduction at shoulder and extension of arms followed by smooth adduction</p>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/moro-reflex-4.svg">
                                </div>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('moro_reflex_score', '4.5', this)" data-cell="moro_reflex_score_4-5" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('moro_reflex_score', '5', this)" data-cell="moro_reflex_score_5" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '5') selected-score @endif">
                                <ul class="table-list">
                                    <li>no abduction or adduction; </li>
                                    <li>only forward extension of arms from the shoulders</li>
                                    <li>marked adduction only</li>
                                </ul>
                                <div class="image-container">
                                    <img src="{{ url('/') }}/public/img/hnne/moro-reflex-5.svg">
                                </div>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->moro_reflex_status = isset($hnne_details->moro_reflex_status) ? $hnne_details->moro_reflex_status : 1; @endphp
                                {{ Form::radio('moro_reflex_status', 1, ($hnne_details->moro_reflex_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('moro_reflex_status', 2, ($hnne_details->moro_reflex_status == 2 ? true : false)) }} Asymmetric                                                        
                                {!! Form::textarea('moro_reflex_asymmetric', @$hnne_details->moro_reflex_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'moro_reflex_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered moro_reflex_score_table">
                                    <tr>
                                        <td class="moro_reflex_score_valid_1_first_group">0</td>
                                        <td class="moro_reflex_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary moro_reflex_score_valid_2_first_group">13</td>
                                        <td class="bg-secondary moro_reflex_score_valid_2-5_first_group">1</td>
                                        <td class="bg-secondary moro_reflex_score_valid_3_first_group">61</td>
                                        <td class="bg-secondary moro_reflex_score_valid_3-5_first_group">4</td>
                                        <td class="bg-secondary moro_reflex_score_valid_4_first_group">20</td>
                                        <td class="moro_reflex_score_valid_4-5_first_group">0</td>
                                        <td class="moro_reflex_score_valid_5_first_group">1</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="moro_reflex_score_valid_1_second_group">0</td>
                                        <td class="moro_reflex_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary moro_reflex_score_valid_2_second_group">12</td>
                                        <td class="bg-secondary moro_reflex_score_valid_2-5_second_group">1</td>
                                        <td class="bg-secondary moro_reflex_score_valid_3_second_group">64</td>
                                        <td class="bg-secondary moro_reflex_score_valid_3-5_second_group">6</td>
                                        <td class="bg-secondary moro_reflex_score_valid_4_second_group">15</td>
                                        <td class="moro_reflex_score_valid_4-5_second_group">1</td>
                                        <td class="moro_reflex_score_valid_5_second_group">1</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="moro_reflex_score_valid_1_third_group">0</td>
                                        <td class="moro_reflex_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary moro_reflex_score_valid_2_third_group">12</td>
                                        <td class="bg-secondary moro_reflex_score_valid_2-5_third_group">1</td>
                                        <td class="bg-secondary moro_reflex_score_valid_3_third_group">51</td>
                                        <td class="bg-secondary moro_reflex_score_valid_3-5_third_group">3</td>
                                        <td class="bg-secondary moro_reflex_score_valid_4_third_group">28</td>
                                        <td class="moro_reflex_score_valid_4-5_third_group">0</td>
                                        <td class="moro_reflex_score_valid_5_third_group">5</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="moro_reflex_score_valid_1_fourth_group">0</td>
                                        <td class="moro_reflex_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary moro_reflex_score_valid_2_fourth_group">23</td>
                                        <td class="bg-secondary moro_reflex_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary moro_reflex_score_valid_3_fourth_group">46</td>
                                        <td class="bg-secondary moro_reflex_score_valid_3-5_fourth_group">2</td>
                                        <td class="bg-secondary moro_reflex_score_valid_4_fourth_group">27</td>
                                        <td class="moro_reflex_score_valid_4-5_fourth_group">0</td>
                                        <td class="moro_reflex_score_valid_5_fourth_group">2</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="moro_reflex_score_valid_1_term_group">0</td>
                                        <td class="moro_reflex_score_valid_1-5_term_group">0</td>
                                        <td class="moro_reflex_score_valid_2_term_group">1</td>
                                        <td class="moro_reflex_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary moro_reflex_score_valid_3_term_group">20</td>
                                        <td class="bg-secondary moro_reflex_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary moro_reflex_score_valid_4_term_group">79</td>
                                        <td class="moro_reflex_score_valid_4-5_term_group">0</td>
                                        <td class="moro_reflex_score_valid_5_term_group">0</td>
                                        <td><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hnnescreening4">
        <div class="row hnne-container">
            <div class="table-responsive">
                <h3><strong>Movements</strong></h3>
                <table class="table valign-middle">
                    <tbody>
                        <tr class="spontaneous-movements">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>SPONTANEOUS <br>MOVEMENTS ( quantity )</strong>
                                <input type="hidden" class="hnne_scores" name="spontaneous_movements_score" value="@if(isset($hnne_details->spontaneous_movements_score)){{ $hnne_details->spontaneous_movements_score }}@endif">
                                <input type="hidden" name="movements[]" id="spontaneous_movements_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('spontaneous_movements_score', '1', this)" data-cell="spontaneous_movements_score_1" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>no movement</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('spontaneous_movements_score', '1.5', this)" data-cell="spontaneous_movements_score_1-5" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('spontaneous_movements_score', '2', this)" data-cell="spontaneous_movements_score_2" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '2') selected-score @endif">
                                <p>sporadic and short isolated movements</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('spontaneous_movements_score', '2.5', this)" data-cell="spontaneous_movements_score_2-5" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('spontaneous_movements_score', '3', this)" data-cell="spontaneous_movements_score_3" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '3') selected-score @endif">
                                <p>frequent isolated movements</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('spontaneous_movements_score', '3.5', this)" data-cell="spontaneous_movements_score_3-5" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('spontaneous_movements_score', '4', this)" data-cell="spontaneous_movements_score_4" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '4') selected-score @endif">
                                <p>frequent generalized movements</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('spontaneous_movements_score', '4.5', this)" data-cell="spontaneous_movements_score_4-5" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('spontaneous_movements_score', '5', this)" data-cell="spontaneous_movements_score_5" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '5') selected-score @endif">
                                <p>continuous exaggerated movements</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->spontaneous_movements_status = isset($hnne_details->spontaneous_movements_status) ? $hnne_details->spontaneous_movements_status : 1; @endphp
                                {{ Form::radio('spontaneous_movements_status', 1, ($hnne_details->spontaneous_movements_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('spontaneous_movements_status', 2, ($hnne_details->spontaneous_movements_status == 2 ? true : false)) }} Asymmetric                            
                                {!! Form::textarea('spontaneous_movements_asymmetric', @$hnne_details->spontaneous_movements_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'spontaneous_movements_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered spontaneous_movements_score_table">
                                    <tr>
                                        <td>1</td>
                                        <td>.5</td>
                                        <td>2</td>
                                        <td>.5</td>
                                        <td>3</td>
                                        <td>.5</td>
                                        <td>4</td>
                                        <td>.5</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td class="spontaneous_movements_score_valid_1_first_group">0</td>
                                        <td class="spontaneous_movements_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_2_first_group">15</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_2-5_first_group">3</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_3_first_group">28</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_3-5_first_group">3</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_4_first_group">51</td>
                                        <td class="spontaneous_movements_score_valid_4-5_first_group">0</td>
                                        <td class="spontaneous_movements_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="spontaneous_movements_score_valid_1_second_group">0</td>
                                        <td class="spontaneous_movements_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_2_second_group">17</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_2-5_second_group">3</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_3_second_group">26</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_3-5_second_group">11</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_4_second_group">43</td>
                                        <td class="spontaneous_movements_score_valid_4-5_second_group">0</td>
                                        <td class="spontaneous_movements_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="spontaneous_movements_score_valid_1_third_group">0</td>
                                        <td class="spontaneous_movements_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_2_third_group">13</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_2-5_third_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_3_third_group">31</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_3-5_third_group">8</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_4_third_group">48</td>
                                        <td class="spontaneous_movements_score_valid_4-5_third_group">0</td>
                                        <td class="spontaneous_movements_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="spontaneous_movements_score_valid_1_fourth_group">0</td>
                                        <td class="spontaneous_movements_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_2_fourth_group">20</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_3_fourth_group">27</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_3-5_fourth_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_4_fourth_group">51</td>
                                        <td class="spontaneous_movements_score_valid_4-5_fourth_group">0</td>
                                        <td class="spontaneous_movements_score_valid_5_fourth_group">2</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="spontaneous_movements_score_valid_1_term_group"><1</td>
                                        <td class="spontaneous_movements_score_valid_1-5_term_group">0</td>
                                        <td class="spontaneous_movements_score_valid_2_term_group">3</td>
                                        <td class="spontaneous_movements_score_valid_2-5_term_group">0</td>
                                        <td class="spontaneous_movements_score_valid_3_term_group">5</td>
                                        <td class="spontaneous_movements_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_score_valid_4_term_group">92</td>
                                        <td class="spontaneous_movements_score_valid_4-5_term_group">0</td>
                                        <td class="spontaneous_movements_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="spontaneous-movements-quality">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>SPONTANEOUS <br>MOVEMENTS ( quality )</strong>
                                <input type="hidden" class="hnne_scores" name="spontaneous_movements_quality_score" value="@if(isset($hnne_details->spontaneous_movements_quality_score)){{ $hnne_details->spontaneous_movements_quality_score }}@endif">
                                <input type="hidden" name="movements[]" id="spontaneous_movements_quality_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('spontaneous_movements_quality_score', '1', this)" data-cell="spontaneous_movements_quality_score_1" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>only stretches</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('spontaneous_movements_quality_score', '1.5', this)" data-cell="spontaneous_movements_quality_score_1-5" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('spontaneous_movements_quality_score', '2', this)" data-cell="spontaneous_movements_quality_score_2" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '2') selected-score @endif">
                                <p>stretches and random abrupt movements</p>
                                <p>Some smooth movements</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('spontaneous_movements_quality_score', '2.5', this)" data-cell="spontaneous_movements_quality_score_2-5" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('spontaneous_movements_quality_score', '3', this)" data-cell="spontaneous_movements_quality_score_3" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '3') selected-score @endif">
                                <p>fluent movements but monotonous</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('spontaneous_movements_quality_score', '3.5', this)" data-cell="spontaneous_movements_quality_score_3-5" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('spontaneous_movements_quality_score', '4', this)" data-cell="spontaneous_movements_quality_score_4" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '4') selected-score @endif">
                                <p>fluent alternating movements of arms + legs;</p>
                                <p>good variability</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('spontaneous_movements_quality_score', '4.5', this)" data-cell="spontaneous_movements_quality_score_4-5" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('spontaneous_movements_quality_score', '5', this)" data-cell="spontaneous_movements_quality_score_5" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '5') selected-score @endif">
                                <p>cramped synchronous</p>
                                <p>mouthing</p>
                                <p>jerky or other abnormal movements</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->spontaneous_movements_quality_status = isset($hnne_details->spontaneous_movements_quality_status) ? $hnne_details->spontaneous_movements_quality_status : 1; @endphp
                                {{ Form::radio('spontaneous_movements_quality_status', 1, ($hnne_details->spontaneous_movements_quality_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('spontaneous_movements_quality_status', 2, ($hnne_details->spontaneous_movements_quality_status == 2 ? true : false)) }} Asymmetric                            
                                {!! Form::textarea('spontaneous_movements_quality_asymmetric', @$hnne_details->spontaneous_movements_quality_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'spontaneous_movements_quality_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered spontaneous_movements_quality_score_table">
                                    <tr>
                                        <td class="spontaneous_movements_quality_score_valid_1_first_group">0</td>
                                        <td class="spontaneous_movements_quality_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_2_first_group">16</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_2-5_first_group">4</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_3_first_group">42</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_3-5_first_group">11</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_4_first_group">23</td>
                                        <td class="spontaneous_movements_quality_score_valid_4-5_first_group">1</td>
                                        <td class="spontaneous_movements_quality_score_valid_5_first_group">3</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="spontaneous_movements_quality_score_valid_1_second_group">0</td>
                                        <td class="spontaneous_movements_quality_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_2_second_group">22</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_2-5_second_group">5</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_3_second_group">35</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_3-5_second_group">1</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_4_second_group">23</td>
                                        <td class="spontaneous_movements_quality_score_valid_4-5_second_group">2</td>
                                        <td class="spontaneous_movements_quality_score_valid_5_second_group">2</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="spontaneous_movements_quality_score_valid_1_third_group">0</td>
                                        <td class="spontaneous_movements_quality_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_2_third_group">20</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_2-5_third_group">6</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_3_third_group">34</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_3-5_third_group">2</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_4_third_group">36</td>
                                        <td class="spontaneous_movements_quality_score_valid_4-5_third_group">0</td>
                                        <td class="spontaneous_movements_quality_score_valid_5_third_group">2</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="spontaneous_movements_quality_score_valid_1_fourth_group">0</td>
                                        <td class="spontaneous_movements_quality_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_2_fourth_group">21</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_3_fourth_group">15</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_3-5_fourth_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_4_fourth_group">60</td>
                                        <td class="spontaneous_movements_quality_score_valid_4-5_fourth_group">0</td>
                                        <td class="spontaneous_movements_quality_score_valid_5_fourth_group">4</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="spontaneous_movements_quality_score_valid_1_term_group">2</td>
                                        <td class="spontaneous_movements_quality_score_valid_1-5_term_group">0</td>
                                        <td class="spontaneous_movements_quality_score_valid_2_term_group">5</td>
                                        <td class="spontaneous_movements_quality_score_valid_2-5_term_group">0</td>
                                        <td class="spontaneous_movements_quality_score_valid_3_term_group"><1</td>
                                        <td class="spontaneous_movements_quality_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary spontaneous_movements_quality_score_valid_4_term_group">93</td>
                                        <td class="spontaneous_movements_quality_score_valid_4-5_term_group">0</td>
                                        <td class="spontaneous_movements_quality_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="head-raising">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>HEAD RAISING</strong>
                                <input type="hidden" class="hnne_scores" name="head_raising_score" value="@if(isset($hnne_details->head_raising_score)){{ $hnne_details->head_raising_score }}@endif">
                                <input type="hidden" name="movements[]" id="head_raising_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('head_raising_score', '1', this)" data-cell="head_raising_score_1" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>no movements</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_raising_score', '1.5', this)" data-cell="head_raising_score_1-5" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('head_raising_score', '2', this)" data-cell="head_raising_score_2" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '2') selected-score @endif">
                                <p>infant rolls head over, chin not raised</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_raising_score', '2.5', this)" data-cell="head_raising_score_2-5" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('head_raising_score', '3', this)" data-cell="head_raising_score_3" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '3') selected-score @endif">
                                <p>infant raises chin, rolls head over</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_raising_score', '3.5', this)" data-cell="head_raising_score_3-5" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('head_raising_score', '4', this)" data-cell="head_raising_score_4" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '4') selected-score @endif">
                                <p>infant brings head and chin up</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('head_raising_score', '4.5', this)" data-cell="head_raising_score_4-5" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('head_raising_score', '5', this)" data-cell="head_raising_score_5" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '5') selected-score @endif">
                                <p>infant brings head up and keeps it up</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->head_raising_status = isset($hnne_details->head_raising_status) ? $hnne_details->head_raising_status : 1; @endphp
                                {{ Form::radio('head_raising_status', 1, ($hnne_details->head_raising_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('head_raising_status', 2, ($hnne_details->head_raising_status == 2 ? true : false)) }} Asymmetric                            
                                {!! Form::textarea('head_raising_asymmetric', @$hnne_details->head_raising_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'head_raising_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered head_raising_score_table">
                                    <tr>
                                        <td class="head_raising_score_valid_1_first_group">0</td>
                                        <td class="head_raising_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary head_raising_score_valid_2_first_group">36</td>
                                        <td class="bg-secondary head_raising_score_valid_2-5_first_group">6</td>
                                        <td class="bg-secondary head_raising_score_valid_3_first_group">34</td>
                                        <td class="bg-secondary head_raising_score_valid_3-5_first_group">9</td>
                                        <td class="bg-secondary head_raising_score_valid_4_first_group">14</td>
                                        <td class="head_raising_score_valid_4-5_first_group">1</td>
                                        <td class="head_raising_score_valid_5_first_group">3</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_raising_score_valid_1_second_group">1</td>
                                        <td class="head_raising_score_valid_1-5_second_group">1</td>
                                        <td class="bg-secondary head_raising_score_valid_2_second_group">35</td>
                                        <td class="bg-secondary head_raising_score_valid_2-5_second_group">4</td>
                                        <td class="bg-secondary head_raising_score_valid_3_second_group">34</td>
                                        <td class="bg-secondary head_raising_score_valid_3-5_second_group">9</td>
                                        <td class="bg-secondary head_raising_score_valid_4_second_group">14</td>
                                        <td class="head_raising_score_valid_4-5_second_group">1</td>
                                        <td class="head_raising_score_valid_5_second_group">1</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_raising_score_valid_1_third_group">1</td>
                                        <td class="head_raising_score_valid_1-5_third_group">1</td>
                                        <td class="bg-secondary head_raising_score_valid_2_third_group">40</td>
                                        <td class="bg-secondary head_raising_score_valid_2-5_third_group">5</td>
                                        <td class="bg-secondary head_raising_score_valid_3_third_group">28</td>
                                        <td class="bg-secondary head_raising_score_valid_3-5_third_group">1</td>
                                        <td class="bg-secondary head_raising_score_valid_4_third_group">21</td>
                                        <td class="head_raising_score_valid_4-5_third_group">1</td>
                                        <td class="head_raising_score_valid_5_third_group">2</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_raising_score_valid_1_fourth_group">0</td>
                                        <td class="head_raising_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary head_raising_score_valid_2_fourth_group">40</td>
                                        <td class="bg-secondary head_raising_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary head_raising_score_valid_3_fourth_group">30</td>
                                        <td class="bg-secondary head_raising_score_valid_3-5_fourth_group">4</td>
                                        <td class="bg-secondary head_raising_score_valid_4_fourth_group">22</td>
                                        <td class="head_raising_score_valid_4-5_fourth_group">2</td>
                                        <td class="head_raising_score_valid_5_fourth_group">2</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="head_raising_score_valid_1_term_group"><1</td>
                                        <td class="head_raising_score_valid_1-5_term_group">0</td>
                                        <td class="bg-secondary head_raising_score_valid_2_term_group">10</td>
                                        <td class="bg-secondary head_raising_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary head_raising_score_valid_3_term_group">50</td>
                                        <td class="bg-secondary head_raising_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary head_raising_score_valid_4_term_group">40</td>
                                        <td class="head_raising_score_valid_4-5_term_group">0</td>
                                        <td class="head_raising_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hnnescreening5">
        <div class="row hnne-container">
            <div class="table-responsive">
                <h3><strong>Abnormal signs</strong></h3>
                <table class="table valign-middle">
                    <tbody>
                        <tr class="abn-hand-toe-postures">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>ABN.HAND OR TOE <br>POSTURES</strong>
                                <input type="hidden" class="hnne_scores" name="abn_hand_toe_postures_score" value="@if(isset($hnne_details->abn_hand_toe_postures_score)){{ $hnne_details->abn_hand_toe_postures_score }}@endif">
                                <input type="hidden" name="abnormal_signs[]" id="abn_hand_toe_postures_score">
                            </td>
                            <td width="14%"></td>
                            <td width="3%"></td>
                            <td width="14%" onclick="updateHNNEScore('abn_hand_toe_postures_score', '2', this)" data-cell="abn_hand_toe_postures_score_2" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '2') selected-score @endif">
                                <p>hands open toes straight most of the time</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('abn_hand_toe_postures_score', '2.5', this)" data-cell="abn_hand_toe_postures_score_2-5" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('abn_hand_toe_postures_score', '3', this)" data-cell="abn_hand_toe_postures_score_3" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '3') selected-score @endif">
                                <p>intermittent fisting or thumb adduction</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('abn_hand_toe_postures_score', '3.5', this)" data-cell="abn_hand_toe_postures_score_3-5" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('abn_hand_toe_postures_score', '4', this)" data-cell="abn_hand_toe_postures_score_4" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '4') selected-score @endif">
                                <p>continuous fisting or thumb adduction; index finger flexion, thumb opposition</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('abn_hand_toe_postures_score', '4.5', this)" data-cell="abn_hand_toe_postures_score_4-5" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('abn_hand_toe_postures_score', '5', this)" data-cell="abn_hand_toe_postures_score_5" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '5') selected-score @endif">
                                <p>continuous big toe  extension or flexion of all toes</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->abn_hand_toe_postures_status = isset($hnne_details->abn_hand_toe_postures_status) ? $hnne_details->abn_hand_toe_postures_status : 1; @endphp
                                {{ Form::radio('abn_hand_toe_postures_status', 1, ($hnne_details->abn_hand_toe_postures_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('abn_hand_toe_postures_status', 2, ($hnne_details->abn_hand_toe_postures_status == 2 ? true : false)) }} Asymmetric                            
                                {!! Form::textarea('abn_hand_toe_postures_asymmetric', @$hnne_details->abn_hand_toe_postures_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'abn_hand_toe_postures_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered abn_hand_toe_postures_score_table">
                                    <tr>
                                        <td>1</td>
                                        <td>.5</td>
                                        <td>2</td>
                                        <td>.5</td>
                                        <td>3</td>
                                        <td>.5</td>
                                        <td>4</td>
                                        <td>.5</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td class="abn_hand_toe_postures_score_valid_1_first_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_2_first_group">57</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_2-5_first_group">4</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_3_first_group">37</td>
                                        <td class="abn_hand_toe_postures_score_valid_3-5_first_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_4_first_group">2</td>
                                        <td class="abn_hand_toe_postures_score_valid_4-5_first_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="abn_hand_toe_postures_score_valid_1_second_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_2_second_group">64</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_2-5_second_group">6</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_3_second_group">28</td>
                                        <td class="abn_hand_toe_postures_score_valid_3-5_second_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_4_second_group">2</td>
                                        <td class="abn_hand_toe_postures_score_valid_4-5_second_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="abn_hand_toe_postures_score_valid_1_third_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_2_third_group">67</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_2-5_third_group">1</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_3_third_group">30</td>
                                        <td class="abn_hand_toe_postures_score_valid_3-5_third_group">1</td>
                                        <td class="abn_hand_toe_postures_score_valid_4_third_group">1</td>
                                        <td class="abn_hand_toe_postures_score_valid_4-5_third_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="abn_hand_toe_postures_score_valid_1_fourth_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_2_fourth_group">75</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_2-5_fourth_group">2</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_3_fourth_group">21</td>
                                        <td class="abn_hand_toe_postures_score_valid_3-5_fourth_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_4_fourth_group">2</td>
                                        <td class="abn_hand_toe_postures_score_valid_4-5_fourth_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="abn_hand_toe_postures_score_valid_1_term_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_1-5_term_group">0</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_2_term_group">85</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary abn_hand_toe_postures_score_valid_3_term_group">12</td>
                                        <td class="abn_hand_toe_postures_score_valid_3-5_term_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_4_term_group">3</td>
                                        <td class="abn_hand_toe_postures_score_valid_4-5_term_group">0</td>
                                        <td class="abn_hand_toe_postures_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="tremor">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>TREMOR</strong>
                                <input type="hidden" class="hnne_scores" name="tremor_score" value="@if(isset($hnne_details->tremor_score)){{ $hnne_details->tremor_score }}@endif">
                                <input type="hidden" name="abnormal_signs[]" id="tremor_score">
                            </td>
                            <td width="14%"></td>
                            <td width="3%"></td>
                            <td width="14%" onclick="updateHNNEScore('tremor_score', '2', this)" data-cell="tremor_score_2" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '2') selected-score @endif">
                                <p>no tremor or tremor or only when crying</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('tremor_score', '2.5', this)" data-cell="tremor_score_2-5" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('tremor_score', '3', this)" data-cell="tremor_score_3" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '3') selected-score @endif">
                                <p>tremor only after Moro or occasionally when awake</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('tremor_score', '3.5', this)" data-cell="tremor_score_3-5" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('tremor_score', '4', this)" data-cell="tremor_score_4" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '4') selected-score @endif">
                                <p>frequent tremors when awake</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('tremor_score', '4.5', this)" data-cell="tremor_score_4-5" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('tremor_score', '5', this)" data-cell="tremor_score_5" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '5') selected-score @endif">
                                <p>continuous tremors</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->tremor_status = isset($hnne_details->tremor_status) ? $hnne_details->tremor_status : 1; @endphp
                                {{ Form::radio('tremor_status', 1, ($hnne_details->tremor_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('tremor_status', 2, ($hnne_details->tremor_status == 2 ? true : false)) }} Asymmetric                            
                                {!! Form::textarea('tremor_asymmetric', @$hnne_details->tremor_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'tremor_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered tremor_score_table">
                                    <tr>
                                        <td class="tremor_score_valid_1_first_group">0</td>
                                        <td class="tremor_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary tremor_score_valid_2_first_group">43</td>
                                        <td class="bg-secondary tremor_score_valid_2-5_first_group">1</td>
                                        <td class="bg-secondary tremor_score_valid_3_first_group">29</td>
                                        <td class="bg-secondary tremor_score_valid_3-5_first_group">8</td>
                                        <td class="bg-secondary tremor_score_valid_4_first_group">16</td>
                                        <td class="tremor_score_valid_4-5_first_group">0</td>
                                        <td class="tremor_score_valid_5_first_group">3</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tremor_score_valid_1_second_group">0</td>
                                        <td class="tremor_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary tremor_score_valid_2_second_group">43</td>
                                        <td class="bg-secondary tremor_score_valid_2-5_second_group">0</td>
                                        <td class="bg-secondary tremor_score_valid_3_second_group">27</td>
                                        <td class="bg-secondary tremor_score_valid_3-5_second_group">9</td>
                                        <td class="bg-secondary tremor_score_valid_4_second_group">19</td>
                                        <td class="tremor_score_valid_4-5_second_group">2</td>
                                        <td class="tremor_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tremor_score_valid_1_third_group">0</td>
                                        <td class="tremor_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary tremor_score_valid_2_third_group">54</td>
                                        <td class="bg-secondary tremor_score_valid_2-5_third_group">0</td>
                                        <td class="bg-secondary tremor_score_valid_3_third_group">24</td>
                                        <td class="bg-secondary tremor_score_valid_3-5_third_group">3</td>
                                        <td class="bg-secondary tremor_score_valid_4_third_group">19</td>
                                        <td class="tremor_score_valid_4-5_third_group">0</td>
                                        <td class="tremor_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tremor_score_valid_1_fourth_group">0</td>
                                        <td class="tremor_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary tremor_score_valid_2_fourth_group">62</td>
                                        <td class="bg-secondary tremor_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary tremor_score_valid_3_fourth_group">30</td>
                                        <td class="tremor_score_valid_3-5_fourth_group">0</td>
                                        <td class="tremor_score_valid_4_fourth_group">4</td>
                                        <td class="tremor_score_valid_4-5_fourth_group">0</td>
                                        <td class="tremor_score_valid_5_fourth_group">4</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tremor_score_valid_1_term_group">0</td>
                                        <td class="tremor_score_valid_1-5_term_group">0</td>
                                        <td class="bg-secondary tremor_score_valid_2_term_group">88</td>
                                        <td class="bg-secondary tremor_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary tremor_score_valid_3_term_group">12</td>
                                        <td class="tremor_score_valid_3-5_term_group">0</td>
                                        <td class="tremor_score_valid_4_term_group"><1</td>
                                        <td class="tremor_score_valid_4-5_term_group">0</td>
                                        <td class="tremor_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="startle">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>STARTLE</strong>
                                <input type="hidden" class="hnne_scores" name="startle_score" value="@if(isset($hnne_details->startle_score)){{ $hnne_details->startle_score }}@endif">
                                <input type="hidden" name="abnormal_signs[]" id="startle_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('startle_score', '1', this)" data-cell="startle_score_1" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>no startle even to sudden noise</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('startle_score', '1.5', this)" data-cell="startle_score_1-5" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('startle_score', '2', this)" data-cell="startle_score_2" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '2') selected-score @endif">
                                <p>no spontaneous startle but reacts to sudden noise</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('startle_score', '2.5', this)" data-cell="startle_score_2-5" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('startle_score', '3', this)" data-cell="startle_score_3" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '3') selected-score @endif">
                                <p>2-3 spontaneous startle</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('startle_score', '3.5', this)" data-cell="startle_score_3-5" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('startle_score', '4', this)" data-cell="startle_score_4" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '4') selected-score @endif">
                                <p>more than 3 spontaneous startle</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('startle_score', '4.5', this)" data-cell="startle_score_4-5" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('startle_score', '5', this)" data-cell="startle_score_5" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '5') selected-score @endif">
                                <p>continuous startle</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->startle_status = isset($hnne_details->startle_status) ? $hnne_details->startle_status : 1; @endphp
                                {{ Form::radio('startle_status', 1, ($hnne_details->startle_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('startle_status', 2, ($hnne_details->startle_status == 2 ? true : false)) }} Asymmetric                            
                                {!! Form::textarea('startle_asymmetric', @$hnne_details->startle_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'startle_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered startle_score_table">
                                    <tr>
                                        <td class="bg-secondary startle_score_valid_1_first_group">22</td>
                                        <td class="bg-secondary startle_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary startle_score_valid_2_first_group">40</td>
                                        <td class="bg-secondary startle_score_valid_2-5_first_group">7</td>
                                        <td class="bg-secondary startle_score_valid_3_first_group">20</td>
                                        <td class="bg-secondary startle_score_valid_3-5_first_group">1</td>
                                        <td class="startle_score_valid_4_first_group">10</td>
                                        <td class="startle_score_valid_4-5_first_group">0</td>
                                        <td class="startle_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary startle_score_valid_1_second_group">23</td>
                                        <td class="bg-secondary startle_score_valid_1-5_second_group">1</td>
                                        <td class="bg-secondary startle_score_valid_2_second_group">35</td>
                                        <td class="bg-secondary startle_score_valid_2-5_second_group">7</td>
                                        <td class="bg-secondary startle_score_valid_3_second_group">30</td>
                                        <td class="startle_score_valid_3-5_second_group">2</td>
                                        <td class="startle_score_valid_4_second_group">2</td>
                                        <td class="startle_score_valid_4-5_second_group">0</td>
                                        <td class="startle_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary startle_score_valid_1_third_group">37</td>
                                        <td class="bg-secondary startle_score_valid_1-5_third_group">1</td>
                                        <td class="bg-secondary startle_score_valid_2_third_group">32</td>
                                        <td class="bg-secondary startle_score_valid_2-5_third_group">1</td>
                                        <td class="bg-secondary startle_score_valid_3_third_group">25</td>
                                        <td class="startle_score_valid_3-5_third_group">1</td>
                                        <td class="startle_score_valid_4_third_group">3</td>
                                        <td class="startle_score_valid_4-5_third_group">0</td>
                                        <td class="startle_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary startle_score_valid_1_fourth_group">50</td>
                                        <td class="bg-secondary startle_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary startle_score_valid_2_fourth_group">35</td>
                                        <td class="bg-secondary startle_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary startle_score_valid_3_fourth_group">9</td>
                                        <td class="startle_score_valid_3-5_fourth_group">0</td>
                                        <td class="startle_score_valid_4_fourth_group">6</td>
                                        <td class="startle_score_valid_4-5_fourth_group">0</td>
                                        <td class="startle_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="startle_score_valid_1_term_group"><1</td>
                                        <td class="startle_score_valid_1-5_term_group">0</td>
                                        <td class="bg-secondary startle_score_valid_2_term_group">94</td>
                                        <td class="startle_score_valid_2-5_term_group">0</td>
                                        <td class="startle_score_valid_3_term_group">6</td>
                                        <td class="startle_score_valid_3-5_term_group">0</td>
                                        <td class="startle_score_valid_4_term_group"><1</td>
                                        <td class="startle_score_valid_4-5_term_group">0</td>
                                        <td class="startle_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="hnnescreening6">
        <div class="row hnne-container">
            <div class="table-responsive">
                <h3><strong>Behavioural signs, vision, hearing</strong></h3>
                <table class="table valign-middle">
                    <tbody>
                        <tr class="eye-appearance">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>EYE APPEARARANCE</strong>
                                <input type="hidden" class="hnne_scores" name="eye_appearance_score" value="@if(isset($hnne_details->eye_appearance_score)){{ $hnne_details->eye_appearance_score }}@endif">
                                <input type="hidden" name="behavioural_signs[]" id="eye_appearance_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('eye_appearance_score', '1', this)" data-cell="eye_appearance_score_1" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '1') selected-score @endif">
                                <p>does not open eyes</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('eye_appearance_score', '1.5', this)" data-cell="eye_appearance_score_1-5" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '1.5') selected-score @endif"></td>
                            <td width="14%"></td>
                            <td width="3%" onclick="updateHNNEScore('eye_appearance_score', '2.5', this)" data-cell="eye_appearance_score_2-5" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('eye_appearance_score', '3', this)" data-cell="eye_appearance_score_3" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '3') selected-score @endif">
                                <p>full conjugated eye move</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('eye_appearance_score', '2.5', this)" data-cell="eye_appearance_score_2-5" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('eye_appearance_score', '4', this)" data-cell="eye_appearance_score_4" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '4') selected-score @endif">
                                <p>trasient</p>
                                <p>nystagmus</p>
                                <p>strabismus</p>
                                <p>roving eye movements</p>
                                <p>sunsetting sign</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('eye_appearance_score', '4.5', this)" data-cell="eye_appearance_score_4-5" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('eye_appearance_score', '5', this)" data-cell="eye_appearance_score_5" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '5') selected-score @endif">
                                <p>persistent</p>
                                <p>nystagmus</p>
                                <p>strabismus</p>
                                <p>roving eye movements</p>
                                <p>downward deviation</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->eye_appearance_status = isset($hnne_details->eye_appearance_status) ? $hnne_details->eye_appearance_status : 1; @endphp
                                {{ Form::radio('eye_appearance_status', 1, ($hnne_details->eye_appearance_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('eye_appearance_status', 2, ($hnne_details->eye_appearance_status == 2 ? true : false)) }} Asymmetric                            
                                {!! Form::textarea('eye_appearance_asymmetric', @$hnne_details->eye_appearance_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'eye_appearance_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered eye_appearance_score_table">
                                    <tr>
                                        <td>1</td>
                                        <td>.5</td>
                                        <td>2</td>
                                        <td>.5</td>
                                        <td>3</td>
                                        <td>.5</td>
                                        <td>4</td>
                                        <td>.5</td>
                                        <td>5</td>
                                    </tr>
                                    <tr>
                                        <td class="eye_appearance_score_valid_1_first_group">6</td>
                                        <td class="eye_appearance_score_valid_1-5_first_group">0</td>
                                        <td class="eye_appearance_score_valid_2_first_group">0</td>
                                        <td class="eye_appearance_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary eye_appearance_score_valid_3_first_group">74</td>
                                        <td class="bg-secondary eye_appearance_score_valid_3-5_first_group">4</td>
                                        <td class="bg-secondary eye_appearance_score_valid_4_first_group">16</td>
                                        <td class="eye_appearance_score_valid_4-5_first_group">0</td>
                                        <td class="eye_appearance_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="eye_appearance_score_valid_1_second_group">2</td>
                                        <td class="eye_appearance_score_valid_1-5_second_group">0</td>
                                        <td class="eye_appearance_score_valid_2_second_group">0</td>
                                        <td class="eye_appearance_score_valid_2-5_second_group">0</td>
                                        <td class="bg-secondary eye_appearance_score_valid_3_second_group">80</td>
                                        <td class="bg-secondary eye_appearance_score_valid_3-5_second_group">2</td>
                                        <td class="bg-secondary eye_appearance_score_valid_4_second_group">15</td>
                                        <td class="eye_appearance_score_valid_4-5_second_group">1</td>
                                        <td class="eye_appearance_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="eye_appearance_score_valid_1_third_group">5</td>
                                        <td class="eye_appearance_score_valid_1-5_third_group">0</td>
                                        <td class="eye_appearance_score_valid_2_third_group">0</td>
                                        <td class="eye_appearance_score_valid_2-5_third_group">0</td>
                                        <td class="bg-secondary eye_appearance_score_valid_3_third_group">80</td>
                                        <td class="bg-secondary eye_appearance_score_valid_3-5_third_group">2</td>
                                        <td class="bg-secondary eye_appearance_score_valid_4_third_group">13</td>
                                        <td class="eye_appearance_score_valid_4-5_third_group">0</td>
                                        <td class="eye_appearance_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="eye_appearance_score_valid_1_fourth_group">4</td>
                                        <td class="eye_appearance_score_valid_1-5_fourth_group">0</td>
                                        <td class="eye_appearance_score_valid_2_fourth_group">0</td>
                                        <td class="eye_appearance_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary eye_appearance_score_valid_3_fourth_group">87</td>
                                        <td class="bg-secondary eye_appearance_score_valid_3-5_fourth_group">2</td>
                                        <td class="bg-secondary eye_appearance_score_valid_4_fourth_group">7</td>
                                        <td class="eye_appearance_score_valid_4-5_fourth_group">0</td>
                                        <td class="eye_appearance_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="eye_appearance_score_valid_1_term_group">7</td>
                                        <td class="eye_appearance_score_valid_1-5_term_group">0</td>
                                        <td class="eye_appearance_score_valid_2_term_group">0</td>
                                        <td class="eye_appearance_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary eye_appearance_score_valid_3_term_group">92</td>
                                        <td class="eye_appearance_score_valid_3-5_term_group">0</td>
                                        <td class="eye_appearance_score_valid_4_term_group">1</td>
                                        <td class="eye_appearance_score_valid_4-5_term_group">0</td>
                                        <td class="eye_appearance_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="auditory-orientation">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>AUDITORY ORIENTATION</strong>
                                <input type="hidden" class="hnne_scores" name="auditory_orientation_score" value="@if(isset($hnne_details->auditory_orientation_score)){{ $hnne_details->auditory_orientation_score }}@endif">
                                <input type="hidden" name="behavioural_signs[]" id="auditory_orientation_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('auditory_orientation_score', '1', this)" data-cell="auditory_orientation_score_1" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '1') selected-score @endif">
                                <p>no reaction</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('auditory_orientation_score', '1.5', this)" data-cell="auditory_orientation_score_1-5" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('auditory_orientation_score', '2', this)" data-cell="auditory_orientation_score_2" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '2') selected-score @endif">
                                <p>auditory startle; Brightness and stills;</p>
                                <p>no true orientation</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('auditory_orientation_score', '2.5', this)" data-cell="auditory_orientation_score_2-5" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('auditory_orientation_score', '3', this)" data-cell="auditory_orientation_score_3" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '3') selected-score @endif">
                                <p>shifting of eyes, head might turn towards source</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('auditory_orientation_score', '3.5', this)" data-cell="auditory_orientation_score_3-5" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('auditory_orientation_score', '4', this)" data-cell="auditory_orientation_score_4" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '4') selected-score @endif">
                                <p>prolonged head turn to stimulus;</p>
                                <p>search with eyes</p>
                                <p>smooth</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('auditory_orientation_score', '4.5', this)" data-cell="auditory_orientation_score_4-5" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('auditory_orientation_score', '5', this)" data-cell="auditory_orientation_score_5" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '5') selected-score @endif">
                                <p>truns head and eyes towards noise erery time;</p>
                                <p>jerky abrupt</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->auditory_orientation_status = isset($hnne_details->auditory_orientation_status) ? $hnne_details->auditory_orientation_status : 1; @endphp
                                {{ Form::radio('auditory_orientation_status', 1, ($hnne_details->auditory_orientation_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('auditory_orientation_status', 2, ($hnne_details->auditory_orientation_status == 2 ? true : false)) }} Asymmetric                                                            
                                {!! Form::textarea('auditory_orientation_asymmetric', @$hnne_details->auditory_orientation_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'auditory_orientation_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered auditory_orientation_score_table">
                                    <tr>
                                        <td class="auditory_orientation_score_valid_1_first_group">5</td>
                                        <td class="auditory_orientation_score_valid_1-5_first_group">1</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_2_first_group">28</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_3_first_group">57</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_3-5_first_group">1</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_4_first_group">8</td>
                                        <td class="auditory_orientation_score_valid_4-5_first_group">0</td>
                                        <td class="auditory_orientation_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="auditory_orientation_score_valid_1_second_group">2</td>
                                        <td class="auditory_orientation_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_2_second_group">23</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_2-5_second_group">10</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_3_second_group">50</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_3-5_second_group">6</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_4_second_group">9</td>
                                        <td class="auditory_orientation_score_valid_4-5_second_group">0</td>
                                        <td class="auditory_orientation_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="auditory_orientation_score_valid_1_third_group">5</td>
                                        <td class="auditory_orientation_score_valid_1-5_third_group">1</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_2_third_group">27</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_2-5_third_group">7</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_3_third_group">51</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_3-5_third_group">1</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_4_third_group">8</td>
                                        <td class="auditory_orientation_score_valid_4-5_third_group">0</td>
                                        <td class="auditory_orientation_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="auditory_orientation_score_valid_1_fourth_group">3</td>
                                        <td class="auditory_orientation_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_2_fourth_group">14</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_3_fourth_group">73</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_3-5_fourth_group">3</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_4_fourth_group">7</td>
                                        <td class="auditory_orientation_score_valid_4-5_fourth_group">0</td>
                                        <td class="auditory_orientation_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="auditory_orientation_score_valid_1_term_group"><1</td>
                                        <td class="auditory_orientation_score_valid_1-5_term_group">0</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_2_term_group">30</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_3_term_group">50</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary auditory_orientation_score_valid_4_term_group">20</td>
                                        <td class="auditory_orientation_score_valid_4-5_term_group">0</td>
                                        <td class="auditory_orientation_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="visual-orientation">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>VISUAL ORIENTATION</strong>
                                <input type="hidden" class="hnne_scores" name="visual_orientation_score" value="@if(isset($hnne_details->visual_orientation_score)){{ $hnne_details->visual_orientation_score }}@endif">
                                <input type="hidden" name="behavioural_signs[]" id="visual_orientation_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('visual_orientation_score', '1', this)" data-cell="visual_orientation_score_1" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>does not follow or focus on stimuli</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('visual_orientation_score', '1.5', this)" data-cell="visual_orientation_score_1-5" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('visual_orientation_score', '2', this)" data-cell="visual_orientation_score_2" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '2') selected-score @endif">
                                <p>stills, focuses follows briefly to the side but loses stimuli</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('visual_orientation_score', '2.5', this)" data-cell="visual_orientation_score_2-5" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('visual_orientation_score', '3', this)" data-cell="visual_orientation_score_3" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '3') selected-score @endif">
                                <p>follows horizontally and vertivcally;</p>
                                <p>no head turn</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('visual_orientation_score', '3.5', this)" data-cell="visual_orientation_score_3-5" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('visual_orientation_score', '4', this)" data-cell="visual_orientation_score_4" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '4') selected-score @endif">
                                <p>follows horizontally and vertivcally;</p>
                                <p>head turn</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('visual_orientation_score', '4.5', this)" data-cell="visual_orientation_score_4-5" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('visual_orientation_score', '5', this)" data-cell="visual_orientation_score_5" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '5') selected-score @endif">
                                <p>follows in a circle</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->visual_orientation_status = isset($hnne_details->visual_orientation_status) ? $hnne_details->visual_orientation_status : 1; @endphp
                                {{ Form::radio('visual_orientation_status', 1, ($hnne_details->visual_orientation_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('visual_orientation_status', 2, ($hnne_details->visual_orientation_status == 2 ? true : false)) }} Asymmetric                                                                                        
                                {!! Form::textarea('visual_orientation_asymmetric', @$hnne_details->visual_orientation_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'visual_orientation_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered visual_orientation_score_table">
                                    <tr>
                                        <td class="visual_orientation_score_valid_1_first_group">6</td>
                                        <td class="visual_orientation_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary visual_orientation_score_valid_2_first_group">7</td>
                                        <td class="bg-secondary visual_orientation_score_valid_2-5_first_group">2</td>
                                        <td class="bg-secondary visual_orientation_score_valid_3_first_group">25</td>
                                        <td class="bg-secondary visual_orientation_score_valid_3-5_first_group">3</td>
                                        <td class="bg-secondary visual_orientation_score_valid_4_first_group">26</td>
                                        <td class="bg-secondary visual_orientation_score_valid_4-5_first_group">9</td>
                                        <td class="bg-secondary visual_orientation_score_valid_5_first_group">22</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="visual_orientation_score_valid_1_second_group">0</td>
                                        <td class="visual_orientation_score_valid_1-5_second_group">0</td>
                                        <td class="visual_orientation_score_valid_2_second_group">7</td>
                                        <td class="visual_orientation_score_valid_2-5_second_group">1</td>
                                        <td class="bg-secondary visual_orientation_score_valid_3_second_group">33</td>
                                        <td class="bg-secondary visual_orientation_score_valid_3-5_second_group">7</td>
                                        <td class="bg-secondary visual_orientation_score_valid_4_second_group">21</td>
                                        <td class="bg-secondary visual_orientation_score_valid_4-5_second_group">15</td>
                                        <td class="bg-secondary visual_orientation_score_valid_5_second_group">16</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="visual_orientation_score_valid_1_third_group">1</td>
                                        <td class="visual_orientation_score_valid_1-5_third_group">0</td>
                                        <td class="visual_orientation_score_valid_2_third_group">9</td>
                                        <td class="visual_orientation_score_valid_2-5_third_group">0</td>
                                        <td class="bg-secondary visual_orientation_score_valid_3_third_group">27</td>
                                        <td class="bg-secondary visual_orientation_score_valid_3-5_third_group">5</td>
                                        <td class="bg-secondary visual_orientation_score_valid_4_third_group">25</td>
                                        <td class="bg-secondary visual_orientation_score_valid_4-5_third_group">10</td>
                                        <td class="bg-secondary visual_orientation_score_valid_5_third_group">23</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="visual_orientation_score_valid_1_fourth_group">0</td>
                                        <td class="visual_orientation_score_valid_1-5_fourth_group">0</td>
                                        <td class="visual_orientation_score_valid_2_fourth_group">10</td>
                                        <td class="visual_orientation_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary visual_orientation_score_valid_3_fourth_group">42</td>
                                        <td class="bg-secondary visual_orientation_score_valid_3-5_fourth_group">10</td>
                                        <td class="bg-secondary visual_orientation_score_valid_4_fourth_group">38</td>
                                        <td class="visual_orientation_score_valid_4-5_fourth_group">0</td>
                                        <td class="visual_orientation_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="visual_orientation_score_valid_1_term_group"><1</td>
                                        <td class="visual_orientation_score_valid_1-5_term_group">0</td>
                                        <td class="visual_orientation_score_valid_2_term_group">7</td>
                                        <td class="visual_orientation_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary visual_orientation_score_valid_3_term_group">41</td>
                                        <td class="bg-secondary visual_orientation_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary visual_orientation_score_valid_4_term_group">51</td>
                                        <td class="visual_orientation_score_valid_4-5_term_group">0</td>
                                        <td class="visual_orientation_score_valid_5_term_group">1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="alertness">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>ALERTNESS</strong>
                                <input type="hidden" class="hnne_scores" name="alertness_score" value="@if(isset($hnne_details->alertness_score)){{ $hnne_details->alertness_score }}@endif">
                                <input type="hidden" name="behavioural_signs[]" id="alertness_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('alertness_score', '1', this)" data-cell="alertness_score_1" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>will not respond to stimuli</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('alertness_score', '1.5', this)" data-cell="alertness_score_1-5" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('alertness_score', '2', this)" data-cell="alertness_score_2" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '2') selected-score @endif">
                                <p>when awake, looks only briefly</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('alertness_score', '2.5', this)" data-cell="alertness_score_2-5" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('alertness_score', '3', this)" data-cell="alertness_score_3" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '3') selected-score @endif">
                                <p>when awake, looks at stimuli but loses them</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('alertness_score', '3.5', this)" data-cell="alertness_score_3-5" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('alertness_score', '4', this)" data-cell="alertness_score_4" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '4') selected-score @endif">
                                <p>keep interset in stimuli</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('alertness_score', '4.5', this)" data-cell="alertness_score_4-5" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('alertness_score', '5', this)" data-cell="alertness_score_5" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '5') selected-score @endif">
                                <p>does not tire (hyper-reactive)</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->alertness_status = isset($hnne_details->alertness_status) ? $hnne_details->alertness_status : 1; @endphp
                                {{ Form::radio('alertness_status', 1, ($hnne_details->alertness_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('alertness_status', 2, ($hnne_details->alertness_status == 2 ? true : false)) }} Asymmetric                                                                                        
                                {!! Form::textarea('alertness_asymmetric', @$hnne_details->alertness_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'alertness_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered alertness_score_table">
                                    <tr>
                                        <td class="alertness_score_valid_1_first_group">6</td>
                                        <td class="alertness_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary alertness_score_valid_2_first_group">22</td>
                                        <td class="bg-secondary alertness_score_valid_2-5_first_group">1</td>
                                        <td class="bg-secondary alertness_score_valid_3_first_group">48</td>
                                        <td class="bg-secondary alertness_score_valid_3-5_first_group">3</td>
                                        <td class="bg-secondary alertness_score_valid_4_first_group">20</td>
                                        <td class="alertness_score_valid_4-5_first_group">0</td>
                                        <td class="alertness_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="alertness_score_valid_1_second_group">1</td>
                                        <td class="alertness_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary alertness_score_valid_2_second_group">17</td>
                                        <td class="bg-secondary alertness_score_valid_2-5_second_group">4</td>
                                        <td class="bg-secondary alertness_score_valid_3_second_group">60</td>
                                        <td class="bg-secondary alertness_score_valid_3-5_second_group">3</td>
                                        <td class="bg-secondary alertness_score_valid_4_second_group">14</td>
                                        <td class="alertness_score_valid_4-5_second_group">1</td>
                                        <td class="alertness_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="alertness_score_valid_1_third_group">0</td>
                                        <td class="alertness_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary alertness_score_valid_2_third_group">21</td>
                                        <td class="bg-secondary alertness_score_valid_2-5_third_group">1</td>
                                        <td class="bg-secondary alertness_score_valid_3_third_group">43</td>
                                        <td class="bg-secondary alertness_score_valid_3-5_third_group">2</td>
                                        <td class="bg-secondary alertness_score_valid_4_third_group">33</td>
                                        <td class="alertness_score_valid_4-5_third_group">0</td>
                                        <td class="alertness_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="alertness_score_valid_1_fourth_group">0</td>
                                        <td class="alertness_score_valid_1-5_fourth_group">0</td>
                                        <td class="alertness_score_valid_2_fourth_group">7</td>
                                        <td class="alertness_score_valid_2-5_fourth_group">3</td>
                                        <td class="bg-secondary alertness_score_valid_3_fourth_group">54</td>
                                        <td class="bg-secondary alertness_score_valid_3-5_fourth_group">0</td>
                                        <td class="bg-secondary alertness_score_valid_4_fourth_group">36</td>
                                        <td class="alertness_score_valid_4-5_fourth_group">0</td>
                                        <td class="alertness_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="alertness_score_valid_1_term_group">1</td>
                                        <td class="alertness_score_valid_1-5_term_group">0</td>
                                        <td class="alertness_score_valid_2_term_group">2</td>
                                        <td class="alertness_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary alertness_score_valid_3_term_group">48</td>
                                        <td class="bg-secondary alertness_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary alertness_score_valid_4_term_group">49</td>
                                        <td class="alertness_score_valid_4-5_term_group">0</td>
                                        <td class="alertness_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="irritability">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>IRRITABILITY</strong>
                                <input type="hidden" class="hnne_scores" name="irritability_score" value="@if(isset($hnne_details->irritability_score)){{ $hnne_details->irritability_score }}@endif">
                                <input type="hidden" name="behavioural_signs[]" id="irritability_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('irritability_score', '1', this)" data-cell="irritability_score_1" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>quiet all the time, not irritable to any stimuli</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('irritability_score', '1.5', this)" data-cell="irritability_score_1-5" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('irritability_score', '2', this)" data-cell="irritability_score_2" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '2') selected-score @endif">
                                <p>awakes, cries sometimes when handled</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('irritability_score', '2.5', this)" data-cell="irritability_score_2-5" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('irritability_score', '3', this)" data-cell="irritability_score_3" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '3') selected-score @endif">
                                <p>cries often when handled</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('irritability_score', '3.5', this)" data-cell="irritability_score_3-5" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('irritability_score', '4', this)" data-cell="irritability_score_4" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '4') selected-score @endif">
                                <p>cries always when handled</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('irritability_score', '4.5', this)" data-cell="irritability_score_4-5" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('irritability_score', '5', this)" data-cell="irritability_score_5" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '5') selected-score @endif">
                                <p>cries even when not handled</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->irritability_status = isset($hnne_details->irritability_status) ? $hnne_details->irritability_status : 1; @endphp
                                {{ Form::radio('irritability_status', 1, ($hnne_details->irritability_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('irritability_status', 2, ($hnne_details->irritability_status == 2 ? true : false)) }} Asymmetric                                                                                                                    
                                {!! Form::textarea('irritability_asymmetric', @$hnne_details->irritability_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'irritability_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered irritability_score_table">
                                    <tr>
                                        <td class="bg-secondary irritability_score_valid_1_first_group">12</td>
                                        <td class="bg-secondary irritability_score_valid_1-5_first_group">1</td>
                                        <td class="bg-secondary irritability_score_valid_2_first_group">52</td>
                                        <td class="bg-secondary irritability_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary irritability_score_valid_3_first_group">31</td>
                                        <td class="irritability_score_valid_3-5_first_group">0</td>
                                        <td class="irritability_score_valid_4_first_group">3</td>
                                        <td class="irritability_score_valid_4-5_first_group">0</td>
                                        <td class="irritability_score_valid_5_first_group">1</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary irritability_score_valid_1_second_group">16</td>
                                        <td class="bg-secondary irritability_score_valid_1-5_second_group">2</td>
                                        <td class="bg-secondary irritability_score_valid_2_second_group">47</td>
                                        <td class="bg-secondary irritability_score_valid_2-5_second_group">2</td>
                                        <td class="bg-secondary irritability_score_valid_3_second_group">27</td>
                                        <td class="irritability_score_valid_3-5_second_group">1</td>
                                        <td class="irritability_score_valid_4_second_group">5</td>
                                        <td class="irritability_score_valid_4-5_second_group">0</td>
                                        <td class="irritability_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary irritability_score_valid_1_third_group">27</td>
                                        <td class="bg-secondary irritability_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary irritability_score_valid_2_third_group">47</td>
                                        <td class="bg-secondary irritability_score_valid_2-5_third_group">1</td>
                                        <td class="bg-secondary irritability_score_valid_3_third_group">22</td>
                                        <td class="irritability_score_valid_3-5_third_group">0</td>
                                        <td class="irritability_score_valid_4_third_group">2</td>
                                        <td class="irritability_score_valid_4-5_third_group">0</td>
                                        <td class="irritability_score_valid_5_third_group">1</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary irritability_score_valid_1_fourth_group">23</td>
                                        <td class="bg-secondary irritability_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary irritability_score_valid_2_fourth_group">49</td>
                                        <td class="bg-secondary irritability_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary irritability_score_valid_3_fourth_group">23</td>
                                        <td class="irritability_score_valid_3-5_fourth_group">0</td>
                                        <td class="irritability_score_valid_4_fourth_group">5</td>
                                        <td class="irritability_score_valid_4-5_fourth_group">0</td>
                                        <td class="irritability_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="irritability_score_valid_1_term_group"><1</td>
                                        <td class="irritability_score_valid_1-5_term_group">0</td>
                                        <td class="bg-secondary irritability_score_valid_2_term_group">93</td>
                                        <td class="irritability_score_valid_2-5_term_group">0</td>
                                        <td class="irritability_score_valid_3_term_group">5</td>
                                        <td class="irritability_score_valid_3-5_term_group">0</td>
                                        <td class="irritability_score_valid_4_term_group">2</td>
                                        <td class="irritability_score_valid_4-5_term_group">0</td>
                                        <td class="irritability_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="consolability">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>CONSOLABILITY</strong>
                                <input type="hidden" class="hnne_scores" name="consolability_score" value="@if(isset($hnne_details->consolability_score)){{ $hnne_details->consolability_score }}@endif">
                                <input type="hidden" name="behavioural_signs[]" id="consolability_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('consolability_score', '1', this)" data-cell="consolability_score_1" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>not crying consoling not needed</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('consolability_score', '1.5', this)" data-cell="consolability_score_1-5" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('consolability_score', '2', this)" data-cell="consolability_score_2" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '2') selected-score @endif">
                                <p>cries briefly;</p>
                                <p>consoling not needed</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('consolability_score', '2.5', this)" data-cell="consolability_score_2-5" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('consolability_score', '3', this)" data-cell="consolability_score_3" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '3') selected-score @endif">
                                <p>cries;</p>
                                <p>becomes quiet when talked to</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('consolability_score', '3.5', this)" data-cell="consolability_score_3-5" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '3.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('consolability_score', '4', this)" data-cell="consolability_score_4" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '4') selected-score @endif">
                                <p>cries;</p>
                                <p>needs picking up to console</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('consolability_score', '4.5', this)" data-cell="consolability_score_4-5" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('consolability_score', '5', this)" data-cell="consolability_score_5" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '5') selected-score @endif">
                                <p>cries cannot be consoled</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->consolability_status = isset($hnne_details->consolability_status) ? $hnne_details->consolability_status : 1; @endphp
                                {{ Form::radio('consolability_status', 1, ($hnne_details->consolability_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('consolability_status', 2, ($hnne_details->consolability_status == 2 ? true : false)) }} Asymmetric                                                                                                                                                
                                {!! Form::textarea('consolability_asymmetric', @$hnne_details->consolability_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'consolability_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered consolability_score_table">
                                    <tr>
                                        <td class="bg-secondary consolability_score_valid_1_first_group">10</td>
                                        <td class="bg-secondary consolability_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary consolability_score_valid_2_first_group">29</td>
                                        <td class="bg-secondary consolability_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary consolability_score_valid_3_first_group">29</td>
                                        <td class="bg-secondary consolability_score_valid_3-5_first_group">3</td>
                                        <td class="bg-secondary consolability_score_valid_4_first_group">29</td>
                                        <td class="consolability_score_valid_4-5_first_group">0</td>
                                        <td class="consolability_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary consolability_score_valid_1_second_group">17</td>
                                        <td class="bg-secondary consolability_score_valid_1-5_second_group">1</td>
                                        <td class="bg-secondary consolability_score_valid_2_second_group">19</td>
                                        <td class="bg-secondary consolability_score_valid_2-5_second_group">2</td>
                                        <td class="bg-secondary consolability_score_valid_3_second_group">29</td>
                                        <td class="bg-secondary consolability_score_valid_3-5_second_group">7</td>
                                        <td class="bg-secondary consolability_score_valid_4_second_group">22</td>
                                        <td class="consolability_score_valid_4-5_second_group">1</td>
                                        <td class="consolability_score_valid_5_second_group">2</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary consolability_score_valid_1_third_group">27</td>
                                        <td class="bg-secondary consolability_score_valid_1-5_third_group">0</td>
                                        <td class="bg-secondary consolability_score_valid_2_third_group">18</td>
                                        <td class="bg-secondary consolability_score_valid_2-5_third_group">0</td>
                                        <td class="bg-secondary consolability_score_valid_3_third_group">28</td>
                                        <td class="bg-secondary consolability_score_valid_3-5_third_group">2</td>
                                        <td class="bg-secondary consolability_score_valid_4_third_group">22</td>
                                        <td class="consolability_score_valid_4-5_third_group">1</td>
                                        <td class="consolability_score_valid_5_third_group">2</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary consolability_score_valid_1_fourth_group">23</td>
                                        <td class="bg-secondary consolability_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary consolability_score_valid_2_fourth_group">9</td>
                                        <td class="bg-secondary consolability_score_valid_2-5_fourth_group">0</td>
                                        <td class="bg-secondary consolability_score_valid_3_fourth_group">32</td>
                                        <td class="bg-secondary consolability_score_valid_3-5_fourth_group">2</td>
                                        <td class="bg-secondary consolability_score_valid_4_fourth_group">28</td>
                                        <td class="consolability_score_valid_4-5_fourth_group">0</td>
                                        <td class="consolability_score_valid_5_fourth_group">6</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>0</td>
                                        <td class="bg-secondary consolability_score_valid_2_term_group">41</td>
                                        <td class="bg-secondary consolability_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary consolability_score_valid_3_term_group">45</td>
                                        <td class="bg-secondary consolability_score_valid_3-5_term_group">0</td>
                                        <td class="bg-secondary consolability_score_valid_4_term_group">12</td>
                                        <td class="consolability_score_valid_4-5_term_group">0</td>
                                        <td class="consolability_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="cry">
                            <td class="row-head" width="3%">
                                <a class="btn btn-default reset"><i class="fa fa-refresh"></i></a>
                                <strong>CRY</strong>
                                <input type="hidden" class="hnne_scores" name="cry_score" value="@if(isset($hnne_details->cry_score)){{ $hnne_details->cry_score }}@endif">
                                <input type="hidden" name="behavioural_signs[]" id="cry_score">
                            </td>
                            <td width="14%" onclick="updateHNNEScore('cry_score', '1', this)" data-cell="cry_score_1" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '1') selected-score @endif" align="center" valign="middle">
                                <p>not cry at all</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('cry_score', '1.5', this)" data-cell="cry_score_1-5" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '1.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('cry_score', '2', this)" data-cell="cry_score_2" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '2') selected-score @endif">
                                <p>whimpering cry only</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('cry_score', '2.5', this)" data-cell="cry_score_2-5" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '2.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('cry_score', '3', this)" data-cell="cry_score_3" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '3') selected-score @endif">
                                <p>cries to stimuli but normal pitch</p>
                            </td>
                            <td width="3%" onclick="updateHNNEScore('cry_score', '3.5', this)" data-cell="cry_score_3-5" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '3.5') selected-score @endif"></td>
                            <td width="14%">
                            </td>
                            <td width="3%" onclick="updateHNNEScore('cry_score', '4.5', this)" data-cell="cry_score_4-5" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '4.5') selected-score @endif"></td>
                            <td width="14%" onclick="updateHNNEScore('cry_score', '5', this)" data-cell="cry_score_5" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '5') selected-score @endif">
                                <p>high pitched cry; often continuous</p>
                            </td>
                            <td width="7%" class="vertical-top">
                                @php $hnne_details->cry_status = isset($hnne_details->cry_status) ? $hnne_details->cry_status : 1; @endphp
                                {{ Form::radio('cry_status', 1, ($hnne_details->cry_status == 1 ? true : false)) }} Symmetric
                                {{ Form::radio('cry_status', 2, ($hnne_details->cry_status == 2 ? true : false)) }} Asymmetric
                                {!! Form::textarea('cry_asymmetric', @$hnne_details->cry_asymmetric, ['class'=>'form-control hide', 'placeholder'=>'Asymmetric', 'id'=>'cry_status_2', 'rows'=>'5']) !!}
                            </td>
                            <td class="no-border" width="10%">
                                <table class="table sub-table table-bordered cry_score_table">
                                    <tr>
                                        <td class="bg-secondary cry_score_valid_1_first_group">11</td>
                                        <td class="bg-secondary cry_score_valid_1-5_first_group">0</td>
                                        <td class="bg-secondary cry_score_valid_2_first_group">11</td>
                                        <td class="bg-secondary cry_score_valid_2-5_first_group">0</td>
                                        <td class="bg-secondary cry_score_valid_3_first_group">78</td>
                                        <td class="cry_score_valid_3-5_first_group">0</td>
                                        <td class="cry_score_valid_4_first_group">0</td>
                                        <td class="cry_score_valid_4-5_first_group">0</td>
                                        <td class="cry_score_valid_5_first_group">0</td>
                                        <td><strong>25-27w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary cry_score_valid_1_second_group">16</td>
                                        <td class="bg-secondary cry_score_valid_1-5_second_group">0</td>
                                        <td class="bg-secondary cry_score_valid_2_second_group">5</td>
                                        <td class="bg-secondary cry_score_valid_2-5_second_group">2</td>
                                        <td class="bg-secondary cry_score_valid_3_second_group">77</td>
                                        <td class="cry_score_valid_3-5_second_group">0</td>
                                        <td class="cry_score_valid_4_second_group">0</td>
                                        <td class="cry_score_valid_4-5_second_group">0</td>
                                        <td class="cry_score_valid_5_second_group">0</td>
                                        <td><strong>28-29w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary cry_score_valid_1_third_group">26</td>
                                        <td class="bg-secondary cry_score_valid_1-5_third_group">1</td>
                                        <td class="bg-secondary cry_score_valid_2_third_group">3</td>
                                        <td class="bg-secondary cry_score_valid_2-5_third_group">1</td>
                                        <td class="bg-secondary cry_score_valid_3_third_group">69</td>
                                        <td class="cry_score_valid_3-5_third_group">0</td>
                                        <td class="cry_score_valid_4_third_group">0</td>
                                        <td class="cry_score_valid_4-5_third_group">0</td>
                                        <td class="cry_score_valid_5_third_group">0</td>
                                        <td><strong>30-31w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-secondary cry_score_valid_1_fourth_group">23</td>
                                        <td class="bg-secondary cry_score_valid_1-5_fourth_group">0</td>
                                        <td class="bg-secondary cry_score_valid_2_fourth_group">6</td>
                                        <td class="bg-secondary cry_score_valid_2-5_fourth_group">2</td>
                                        <td class="bg-secondary cry_score_valid_3_fourth_group">69</td>
                                        <td class="cry_score_valid_3-5_fourth_group">0</td>
                                        <td class="cry_score_valid_4_fourth_group">0</td>
                                        <td class="cry_score_valid_4-5_fourth_group">0</td>
                                        <td class="cry_score_valid_5_fourth_group">0</td>
                                        <td><strong>32-34w</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="cry_score_valid_1_term_group"><1</td>
                                        <td class="cry_score_valid_1-5_term_group">0</td>
                                        <td class="cry_score_valid_2_term_group">7</td>
                                        <td class="cry_score_valid_2-5_term_group">0</td>
                                        <td class="bg-secondary cry_score_valid_3_term_group">92</td>
                                        <td class="cry_score_valid_3-5_term_group">0</td>
                                        <td class="cry_score_valid_4_term_group">0</td>
                                        <td class="cry_score_valid_4-5_term_group">0</td>
                                        <td class="cry_score_valid_5_term_group"><1</td>
                                        <td style="white-space: nowrap;"><strong>Full term</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" class="text-center">
                                <span class="btn btn-total">Total : <b>0</b></span>
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
            {!! Form::label('hnne_interpretation','Interpretation:') !!}
            {!! Form::select('hnne_interpretation', $hnne_hine_interpretation_options, null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('hnne_interpretation_others','Note:') !!}
            {!! Form::textarea('hnne_interpretation_others', null,['class'=>'form-control', 'rows'=>2]) !!}
        </div>
    </div>
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
    <div class="col-md-12 text-center mtb-20">
        <input type="hidden" name="total_hnne_score" class="total_hnne_score_input" value="@if(isset($hnne_details->total_hnne_score)){{ $hnne_details->total_hnne_score }}@endif">
        <label class="label label-success total-score-label">TOTAL HNNE SCORE: <span class="total_score_element"></span></label>
    </div>
</div>
<script type="text/javascript">
    function updateHNNEScore(type, score, element) {
        var baby_birth_gestation = (!isNaN($('#g_weeks').val())) ? parseInt($('#g_weeks').val()) : 0;

        var age_group = '';
        switch (true) {

            case (baby_birth_gestation > 36):
            age_group = "term_group";
            break;

            case (baby_birth_gestation >= 32 && baby_birth_gestation <= 36):
            age_group = "fourth_group";
            break;

            case (baby_birth_gestation >= 30 && baby_birth_gestation <= 31):
            age_group = "third_group";
            break;

            case (baby_birth_gestation >= 28 && baby_birth_gestation <= 29):
            age_group = "second_group";
            break;

            case (baby_birth_gestation >= 25 && baby_birth_gestation <= 27):
            age_group = "first_group";
            break;
        }

        if (age_group != '') {
            var formatted_score = score.replace('.', '-');

            $('.' + type + '_table').find('.selected-cell').removeClass('selected-cell');
            $('.' + type + '_table').find('.not-valid-value-cell').removeClass('not-valid-value-cell');
            if ($('.' + type + '_valid_' + formatted_score + '_' + age_group)[0]) {
                if ($('.' + type + '_valid_' + formatted_score + '_' + age_group).hasClass('bg-secondary')) {
                    $('.' + type + '_valid_' + formatted_score + '_' + age_group).addClass('selected-cell');
                    $('#'+type).val(1);
                } else {
                    $('.' + type + '_valid_' + formatted_score + '_' + age_group).addClass('not-valid-value-cell');
                    $('#'+type).val(0);
                }
            }
            if ($(element).parents('table').hasClass('posture-table')) {
                $('input[name="' + type + '"]').val(score).trigger('change');
            } else {
                $('input[name="' + type + '"]').val(score);
            }
        }
        $('.' + type + '_field').removeClass('selected-score');
        $(element).addClass('selected-score');
        calculateHNNETotalScore(baby_birth_gestation);

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

    function updateScore(type, score, element) {
        $('.' + type + '_field').removeClass('selected-score');
        $(element).addClass('selected-score');
    }

    function calculateHNNETotalScore(baby_birth_gestation) {
        var total_score = $('.selected-cell').length;
        $('.total_score_element').text(total_score);
        var baby_response = '';
        if (baby_birth_gestation > 36) {
            if (total_score >= 30.5) {
                $('.total_score_element').parent().removeClass('label-danger').addClass('label-success');
                $('#hnne_tab .total_score').text("("+total_score+") Normal response for the age.").removeClass('label-danger').addClass('label-success');
                baby_response = 'N';
            } else {
                $('.total_score_element').parent().removeClass('label-success').addClass('label-danger');
                $('#hnne_tab .total_score').text("("+total_score+") Weak response for the age.").removeClass('label-success').addClass('label-danger');
                baby_response = 'W';
            }
        } else {
            if (total_score >= 26) {
                $('.total_score_element').parent().removeClass('label-danger').addClass('label-success');
                $('#hnne_tab .total_score').text("("+total_score+") Normal response for the corrected age.").removeClass('label-danger').addClass('label-success');
                baby_response = 'N';
            } else {
                $('.total_score_element').parent().removeClass('label-success').addClass('label-danger');
                $('#hnne_tab .total_score').text("("+total_score+") Weak response for the corrected age.").removeClass('label-success').addClass('label-danger');
                baby_response = 'W';
            }
        }
        $('#hnne_tab .total_score').parent().removeClass('hide');
        $('.total_hnne_score_input').val(total_score+'-'+baby_response);
    }
    @if(isset($hnne_details) && count($hnne_details) > 0)
    $('.hnne_scores').each(function () {
        if ($(this).val() && $(this).val() != 0) {
            var remove_dot = $(this).val().replace('.', '-').trim();
            var element = $('table').find("[data-cell='" + $(this).attr('name') + '_' + remove_dot + "']");
            updateHNNEScore($(this).attr('name'), $(this).val().trim(), element);
        }
    });
    @endif

    $('#hnnescreening1 input[name="arm_traction_score"], #hnnescreening1 input[name="leg_traction_score"]').on('change', function() {
        var comparing_value_1 = $('#hnnescreening1 input[name="arm_traction_score"]').val();
        var comparing_value_2 = $('#hnnescreening1 input[name="leg_traction_score"]').val();

        if (comparing_value_1 < comparing_value_2) {
            $('.flexor_tone_score_field[data-cell="flexor_tone_score_1"]').trigger('click');
        } else if (comparing_value_1 == comparing_value_2) {
            $('.flexor_tone_score_field[data-cell="flexor_tone_score_2"]').trigger('click');
        } else if (comparing_value_1 > comparing_value_2 && (comparing_value_1 - comparing_value_2) <= 1) {
            $('.flexor_tone_score_field[data-cell="flexor_tone_score_3"]').trigger('click');
        } else if (comparing_value_1 > comparing_value_2 && (comparing_value_1 - comparing_value_2) > 1) {
            $('.flexor_tone_score_field[data-cell="flexor_tone_score_4"]').trigger('click');
        }
    });
    $('#hnnescreening1 input[name="leg_traction_score"], #hnnescreening1 input[name="popliteal_angle_score"]').on('change', function() {
        var comparing_value_1 = $('#hnnescreening1 input[name="leg_traction_score"]').val();
        var comparing_value_2 = $('#hnnescreening1 input[name="popliteal_angle_score"]').val();

        if (comparing_value_1 > comparing_value_2) {
            $('.leg_tone_score_field[data-cell="leg_tone_score_2"]').trigger('click');
        } else if (comparing_value_1 == comparing_value_2) {
            $('.leg_tone_score_field[data-cell="leg_tone_score_3"]').trigger('click');
        } else if (comparing_value_1 < comparing_value_2 && (comparing_value_1 - comparing_value_2) <= 1) {
            $('.leg_tone_score_field[data-cell="leg_tone_score_4"]').trigger('click');
        } else if (comparing_value_1 < comparing_value_2 && (comparing_value_1 - comparing_value_2) > 1) {
            $('.leg_tone_score_field[data-cell="leg_tone_score_5"]').trigger('click');
        }
    });
    $('#hnnescreening1 input[name="head_control_score"], #hnnescreening1 input[name="head_control_2_score"]').on('change', function() {
        var comparing_value_1 = $('#hnnescreening1 input[name="head_control_score"]').val();
        var comparing_value_2 = $('#hnnescreening1 input[name="head_control_2_score"]').val();

        if (comparing_value_1 < comparing_value_2) {
            $('.head_control_sitting_score_field[data-cell="head_control_sitting_score_2"]').trigger('click');
        } else if (comparing_value_1 == comparing_value_2) {
            $('.head_control_sitting_score_field[data-cell="head_control_sitting_score_3"]').trigger('click');
        } else if (comparing_value_1 > comparing_value_2 && (comparing_value_1 - comparing_value_2) <= 1) {
            $('.head_control_sitting_score_field[data-cell="head_control_sitting_score_4"]').trigger('click');
        } else if (comparing_value_1 > comparing_value_2 && (comparing_value_1 - comparing_value_2) > 1) {
            $('.head_control_sitting_score_field[data-cell="head_control_sitting_score_5"]').trigger('click');
        }
    });
    $('#hnnescreening1 input[name="ventral_suspension_score"], #hnnescreening1 input[name="head_lag_score"]').on('change', function() {
        var comparing_value_1 = $('#hnnescreening1 input[name="ventral_suspension_score"]').val();
        var comparing_value_2 = $('#hnnescreening1 input[name="head_lag_score"]').val();

        if (comparing_value_1 < comparing_value_2) {
            $('.neck_axial_tone_score_field[data-cell="neck_axial_tone_score_2"]').trigger('click');
        } else if (comparing_value_1 == comparing_value_2) {
            $('.neck_axial_tone_score_field[data-cell="neck_axial_tone_score_3"]').trigger('click');
        } else if (comparing_value_1 > comparing_value_2 && (comparing_value_1 - comparing_value_2) <= 1) {
            $('.neck_axial_tone_score_field[data-cell="neck_axial_tone_score_4"]').trigger('click');
        } else if (comparing_value_1 > comparing_value_2 && (comparing_value_1 - comparing_value_2) > 1) {
            $('.neck_axial_tone_score_field[data-cell="neck_axial_tone_score_5"]').trigger('click');
        }
    });

    var custom_hnne_trigger = false;

    $(document).ready(function() {
        $('#hnne_form input[type="radio"][value="2"][checked="checked"]').each(function () {
            custom_hnne_trigger = true;
            $(this).trigger('change');
        });
    });
    $(document).on('change', '#hnne_form input[type="radio"]', function() {
        var value = $(this).val();
        var field_name = $(this).attr('name');
        if (custom_hnne_trigger == false) {
            if (value == 2) {
                $('#'+field_name+'_2').val('').removeClass('hide').focus();
            } else {
                $('#'+field_name+'_2').val('').addClass('hide');
            }
        } else {
            if (value == 2) {
                $('#'+field_name+'_2').removeClass('hide')
            } else {
                $('#'+field_name+'_2').addClass('hide');
            }
            custom_hnne_trigger = false;
        }
    });
    $('#hnne_form .reset').on('click', function() {
        $(this).parents('tr').find('td').removeClass('selected-score');
        $(this).parents('tr').find('td:first-child input').val('');
        var type = $(this).parents('tr').find('td:first-child').find('input').attr('name');
        updateHNNEScore(type, '');
    });
</script>
