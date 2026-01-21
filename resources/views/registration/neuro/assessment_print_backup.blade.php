@extends('print')
@section('content')
@php $site_url = url('/').'/public'; @endphp
<script type="text/javascript" src="{{$site_url}}/js/amcharts5/index.js"></script>
<script type="text/javascript" src="{{$site_url}}/js/amcharts5/xy.js"></script>
<script type="text/javascript" src="{{$site_url}}/js/amcharts5/plugins/exporting.js"></script>
<script type="text/javascript" src="{{ $site_url }}/js/ddst_chart.js?rev=<?php echo time();?>"></script>
<link rel="stylesheet" type="text/css" href="{{ $site_url }}/css/ddst_chart.css?rev=<?php echo time();?>">
<div class="temp-container">
<div class="temp-row">
    <div class="col-md-12">
        <div class="row">
            <div class="assessment-container col-md-12" id="hnne-container">
                {!! Form::hidden('assessment_g_weeks',@$baby_detail->g_weeks) !!}
                @include('registration.neuro.assessment_print_header')
                @php 
                    $hnne_score = explode('-', $hnne_details->total_hnne_score);
                    $total_hnne_score = $hnne_score[0];
                    $hnne_status = isset($hnne_score[1]) ? $hnne_score[1] : '';
                @endphp                
                @if ($hnne_status == 'W')
                    @php $hnne_status = 'Weak'; @endphp
                @else
                    @php $hnne_status = 'Normal'; @endphp
                @endif
                <span id="assessment-score-1" class="hide">Score = {{ $total_hnne_score }}</span>
                <span id="assessment-status-1" class="hide">Status: {{ $hnne_status }}</span>
                <div id="hnnescreening1">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="11">
                                    <h4 class="m-0">
                                        <strong>Posture <span class="pull-right">{{ $hnne_details->posture }} / {{ $overall_score->posture }}</span></strong>
                                    </h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="posture">
                                <td class="row-head" rowspan="2">
                                    <strong>POSTURE</strong>
                                </td>
                                <td data-cell="posture_score_1" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == 1) selected-score @endif">
                                    <p>arms & legs extended or very slightly flexed</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/posture-1.svg">
                                    </div>
                                </td>
                                <td data-cell="posture_score_1-5" class="table-custom-width posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '1.5') selected-score @endif"></td>
                                <td data-cell="posture_score_2" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '2') selected-score @endif">
                                    <p>legs slightly flexed</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/posture-2.svg">
                                    </div>
                                </td>
                                <td data-cell="posture_score_2-5" class="table-custom-width posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '2.5') selected-score @endif"></td>
                                <td data-cell="posture_score_3" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '3') selected-score @endif">
                                    <p>legs well-flexed but not adducted</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/posture-3.svg">
                                    </div>
                                </td>
                                <td data-cell="posture_score_3-5" class="table-custom-width posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '3.5') selected-score @endif"></td>
                                <td data-cell="posture_score_4" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '4') selected-score @endif">
                                    <p>legs well flexed & adducted near abdomen</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/posture-4.svg">
                                    </div>
                                </td>
                                <td data-cell="posture_score_4-5" class="table-custom-width posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '4.5') selected-score @endif"></td>
                                <td data-cell="posture_score_5" class="posture_score_field @if(isset($hnne_details->posture_score) && $hnne_details->posture_score == '5') selected-score @endif">
                                    <p>abnormal postures: marked extension of legs / strong arm flexion/ opisthotonus</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/posture-5.svg">
                                    </div>
                                </td>
                                <td class="no-border" rowspan="2">
                                    <table class="table sub-table table-bordered posture_score_table">
                                        <tr>
                                            <td class="posture_score_valid_1_zero_group">1</td>
                                            <td class="posture_score_valid_1-5_zero_group">.5</td>
                                            <td class="posture_score_valid_2_zero_group">2</td>
                                            <td class="posture_score_valid_2-5_zero_group">.5</td>
                                            <td class="posture_score_valid_3_zero_group">3</td>
                                            <td class="posture_score_valid_3-5_fzerogroup">.5</td>
                                            <td class="posture_score_valid_4_zero_group">4</td>
                                            <td class="posture_score_valid_4-5_zero_group">.5</td>
                                            <td class="posture_score_valid_5_zero_group">5</td>
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
                                            <td>
                                                <strong>25-27w</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="added-info {{ $hnne_details->posture_status == 2 ? '' : 'hide' }}" colspan="9">{!! $hnne_details->posture_asymmetric !!} </td>
                            </tr>
                            <tr class="arm-recoil">
                                <td class="row-head" rowspan="2">
                                    <strong>ARM RECOIL</strong>
                                </td>
                                <td data-cell="arm_recoil_score_1" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '1') selected-score @endif">
                                    <p>arms do not flex</p>
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/arm-recoil-1.svg">
                                    </div>
                                </td>
                                <td data-cell="arm_recoil_score_1-5" class="table-custom-width arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '1.5') selected-score @endif"></td>
                                <td data-cell="arm_recoil_score_2" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '2') selected-score @endif">
                                    <p>arms flex slowly, not always & not completely</p>
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/arm-recoil-2.svg">
                                    </div>
                                </td>
                                <td data-cell="arm_recoil_score_2-5" class="table-custom-width arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '2.5') selected-score @endif"></td>
                                <td data-cell="arm_recoil_score_3" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '3') selected-score @endif">
                                    <p>arms flex slowly, more completely</p>
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/arm-recoil-3.svg">
                                    </div>
                                </td>
                                <td data-cell="arm_recoil_score_3-5" class="table-custom-width arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '3.5') selected-score @endif"></td>
                                <td data-cell="arm_recoil_score_4" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '4') selected-score @endif">
                                    <p>arms flex quickly and completely</p>
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/arm-recoil-4.svg">
                                    </div>
                                </td>
                                <td data-cell="arm_recoil_score_4-5" class="table-custom-width arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '4.5') selected-score @endif"></td>
                                <td data-cell="arm_recoil_score_5" class="arm_recoil_score_field @if(isset($hnne_details->arm_recoil_score) && $hnne_details->arm_recoil_score == '5') selected-score @endif">
                                    <p>arms difficult to extend and may snap back forcefully</p>
                                    <div class="image-container"></div>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                            <td>
                                                <strong>25-27W</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="added-info {{ $hnne_details->arm_recoil_status == 2 ? '' : 'hide' }}" colspan="9">{!! $hnne_details->arm_recoil_asymmetric !!} </td>
                            </tr>
                            <tr class="arm-traction">
                                <td class="row-head" rowspan="2">
                                    <strong>ARM TRACTION</strong>
                                </td>
                                <td data-cell="arm_traction_score_1" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '1') selected-score @endif ">
                                    <p>arm remains straight - no resistance felt</p>
                                    <div class="image-container side-indication">
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                        <img src="{{ url('/') }}/public/img/hnne/arm-traction-1.svg">
                                    </div>
                                </td>
                                <td data-cell="arm_traction_score_1-5" class="table-custom-width arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '1.5') selected-score @endif"></td>
                                <td data-cell="arm_traction_score_2" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '2') selected-score @endif ">
                                    <p>arm flexes slightly or some resistance felt</p>
                                    <div class="image-container side-indication">
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                        <img src="{{ url('/') }}/public/img/hnne/arm-traction-2.svg">
                                    </div>
                                </td>
                                <td data-cell="arm_traction_score_2-5" class="table-custom-width arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '2.5') selected-score @endif"></td>
                                <td data-cell="arm_traction_score_3" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '3') selected-score @endif">
                                    <p>arm flexes well till shoulder lifts, then straightens</p>
                                    <div class="image-container side-indication">
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                        <img src="{{ url('/') }}/public/img/hnne/arm-traction-3.svg">
                                    </div>
                                </td>
                                <td data-cell="arm_traction_score_3-5" class="table-custom-width arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '3.5') selected-score @endif"></td>
                                <td data-cell="arm_traction_score_4" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '4') selected-score @endif ">
                                    <p>arm flexes at ~100 and maintained as shoulder lifts</p>
                                    <div class="image-container side-indication">
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                        <img src="{{ url('/') }}/public/img/hnne/arm-traction-4.svg">
                                    </div>
                                </td>
                                <td data-cell="arm_traction_score_4-5" class="table-custom-width arm_traction_score_field @if(isset($hnne_details->arm_traction_score) && $hnne_details->arm_traction_score == '4.5') selected-score @endif"></td>
                                <td data-cell="arm_traction_score_5" class="arm_traction_score_field @if(isset($hnne_details->arm_traction_score_field) && $hnne_details->arm_traction_score_field == '5') selected-score @endif ">
                                    <p>arms flexed ( <100 ) & maintained when body lifts up </p>
                                    <div class="image-container side-indication">
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                        <img src="{{ url('/') }}/public/img/hnne/arm-traction-5.svg">
                                    </div>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                            <td>
                                                <strong>25-27W</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="added-info {{ $hnne_details->arm_traction_status == 2 ? '' : 'hide'  }}" colspan="9">{!! $hnne_details->arm_traction_asymmetric !!} </td>
                            </tr>
                            <tr class="leg-recoil">
                                <td class="row-head" rowspan="2">
                                    <strong>LEG RECOIL</strong>
                                </td>
                                <td data-cell="leg_recoil_score_1" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '1') selected-score @endif">
                                    <p>No flexion</p>
                                    <div class="image-container">
                                        <i class="fa fa-arrow-left" aria-hidden="true"></i> <br> <i class="fa fa-arrow-right" aria-hidden="true"></i> 
                                        <img src="{{ url('/') }}/public/img/hnne/leg-recoil-1.svg">
                                    </div>
                                </td>
                                <td data-cell="leg_recoil_score_1-5" class="table-custom-width leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '1.5') selected-score @endif"></td>
                                <td data-cell="leg_recoil_score_2" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '2') selected-score @endif">
                                    <p>Incomplete or variable flexion</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/leg-recoil-2.svg">
                                    </div>
                                </td>
                                <td data-cell="leg_recoil_score_2-5" class="table-custom-width leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '2.5') selected-score @endif"></td>
                                <td data-cell="leg_recoil_score_3" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '3') selected-score @endif">
                                    <p>complete but slow flexion</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/leg-recoil-3.svg">
                                    </div>
                                </td>
                                <td data-cell="leg_recoil_score_3-5" class="table-custom-width leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '3.5') selected-score @endif"></td>
                                <td data-cell="leg_recoil_score_4" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '4') selected-score @endif">
                                    <p>complete fast flexion</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/leg-recoil-4.svg">
                                    </div>
                                </td>
                                <td data-cell="leg_recoil_score_4-5" class="table-custom-width leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '4.5') selected-score @endif"></td>
                                <td data-cell="leg_recoil_score_5" class="leg_recoil_score_field @if(isset($hnne_details->leg_recoil_score) && $hnne_details->leg_recoil_score == '5') selected-score @endif">
                                    <p>legs difficult to extend; may snap back forcefully</p>
                                    <div class="image-container"></div>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                            <td>
                                                <strong>25-27W</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="added-info {{ $hnne_details->leg_recoil_status == 2 ? '' : 'hide' }}" colspan="9">{!! $hnne_details->leg_recoil_asymmetric !!} </td>
                            </tr>
                            <tr class="leg-traction">
                                <td class="row-head" rowspan="2">
                                    <strong>LEG TRACTION</strong>
                                </td>
                                <td data-cell="leg_traction_score_1" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '1') selected-score @endif">
                                    <p>leg straight - no resistance felt</p>
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/leg-traction-1.svg">
                                    </div>
                                </td>
                                <td data-cell="leg_traction_score_1-5" class="table-custom-width leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '1.5') selected-score @endif"></td>
                                <td data-cell="leg_traction_score_2" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '2') selected-score @endif">
                                    <p>leg flexes slightly / some resistance felt</p>
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/leg-traction-2.svg">
                                    </div>
                                </td>
                                <td data-cell="leg_traction_score_2-5" class="table-custom-width leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '2.5') selected-score @endif"></td>
                                <td data-cell="leg_traction_score_3" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '3') selected-score @endif">
                                    <p>leg flexes well till bottom lifts up</p>
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/leg-traction-3.svg">
                                    </div>
                                </td>
                                <td data-cell="leg_traction_score_3-5" class="table-custom-width leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '3.5') selected-score @endif"></td>
                                <td data-cell="leg_traction_score_4" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '4') selected-score @endif">
                                    <p>knee remains flexed when bottom up</p>
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/leg-traction-4.svg">
                                    </div>
                                </td>
                                <td data-cell="leg_traction_score_4-5" class="table-custom-width leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '4.5') selected-score @endif"></td>
                                <td data-cell="leg_traction_score_5" class="leg_traction_score_field @if(isset($hnne_details->leg_traction_score) && $hnne_details->leg_traction_score == '5') selected-score @endif">
                                    <p>flexion stays when back+bottom up</p>
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/leg-traction-5.svg">
                                    </div>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                            <td>
                                                <strong>25-27W</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="added-info {{ $hnne_details->leg_traction_status == 2 ? '' : 'hide' }}" colspan="9">{!! $hnne_details->leg_traction_asymmetric !!} </td>
                            </tr>
                            <tr class="popliteal-angle">
                                <td class="row-head" rowspan="2">
                                    <strong>POPLITEAL ANGLE</strong>
                                </td>
                                <td data-cell="popliteal_angle_score_1" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '1') selected-score @endif">
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/popliteal-angle-1.svg">
                                        <i>180 <sup>&deg;</sup>
                                        </i>
                                    </div>
                                </td>
                                <td data-cell="popliteal_angle_score_1-5" class="table-custom-width popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '1.5') selected-score @endif"></td>
                                <td data-cell="popliteal_angle_score_2" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '2') selected-score @endif">
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/popliteal-angle-2.svg">
                                        <i>=150 <sup>&deg;</sup>
                                        </i>
                                    </div>
                                </td>
                                <td data-cell="popliteal_angle_score_2-5" class="table-custom-width popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '2.5') selected-score @endif"></td>
                                <td data-cell="popliteal_angle_score_3" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '3') selected-score @endif">
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/popliteal-angle-3.svg">
                                        <i>=110 <sup>&deg;</sup>
                                        </i>
                                    </div>
                                </td>
                                <td data-cell="popliteal_angle_score_3-5" class="table-custom-width popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '3.5') selected-score @endif"></td>
                                <td data-cell="popliteal_angle_score_4" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '4') selected-score @endif">
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/popliteal-angle-4.svg">
                                        <i>=90 <sup>&deg;</sup>
                                        </i>
                                    </div>
                                </td>
                                <td data-cell="popliteal_angle_score_4-5" class="table-custom-width popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '4.5') selected-score @endif"></td>
                                <td data-cell="popliteal_angle_score_5" class="popliteal_angle_score_field @if(isset($hnne_details->popliteal_angle_score) && $hnne_details->popliteal_angle_score == '5') selected-score @endif">
                                    <div class="image-container side-indication">
                                        <img src="{{ url('/') }}/public/img/hnne/popliteal-angle-5.svg">
                                        <i>
                                        <90 <sup>&deg;</sup>
                                        </i>
                                    </div>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                            <td>
                                                <strong>25-27W</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="added-info {{ $hnne_details->popliteal_angle_status == 2 ? '' : 'hide' }}" colspan="9">{!! $hnne_details->popliteal_angle_asymmetric !!} </td>
                            </tr>
                            <tr class="head-control">
                                <td class="row-head" rowspan="2">
                                    <strong>HEAD CONTROL (1)</strong>
                                </td>
                                <td data-cell="head_control_score_1" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '1') selected-score @endif">
                                    <p> no attempt to HEAD CONTROL (1) raise head </p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-control-1.svg">
                                    </div>
                                </td>
                                <td data-cell="head_control_score_1-5" class="table-custom-width head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '1.5') selected-score @endif"></td>
                                <td data-cell="head_control_score_2" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '2') selected-score @endif">
                                    <p>infant tries: effort better felt than seen</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-control-2.svg">
                                    </div>
                                </td>
                                <td data-cell="head_control_score_2-5" class="table-custom-width head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '2.5') selected-score @endif"></td>
                                <td data-cell="head_control_score_3" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '3') selected-score @endif">
                                    <p>raises head but head drops forward or back</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-control-3.svg">
                                    </div>
                                </td>
                                <td data-cell="head_control_score_3-5" class="table-custom-width head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '3.5') selected-score @endif"></td>
                                <td data-cell="head_control_score_4" class="head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '4') selected-score @endif">
                                    <p>raises head; head remains vertical, wobbles</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-control-4.svg">
                                    </div>
                                </td>
                                <td data-cell="head_control_score_4-5" class="table-custom-width head_control_score_field @if(isset($hnne_details->head_control_score) && $hnne_details->head_control_score == '4.5') selected-score @endif"></td>
                                <td class="head_control_score_field">
                                    <div class="image-container"></div>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                            <td>
                                                <strong>25-27W</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="added-info {{ $hnne_details->head_control_status == 2 ? '' : 'hide' }}" colspan="9">{!! $hnne_details->head_control_asymmetric !!} </td>
                            </tr>
                            <tr class="head-control-flexor">
                                <td class="row-head" rowspan="2">
                                    <strong>HEAD CONTROL (2)</strong>
                                </td>
                                <td data-cell="head_control_two_score_1" class="head_control_two_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '1') selected-score @endif">
                                    <p> no attempt to HEAD CONTROL (1) raise head </p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-control-flxor-1.svg">
                                    </div>
                                </td>
                                <td data-cell="head_control_two_score_1-5" class="table-custom-width head_control_two_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '1.5') selected-score @endif"></td>
                                <td data-cell="head_control_two_score_2" class="head_control_two_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '2') selected-score @endif">
                                    <p>infant tries: effort better felt than seen</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-control-flxor-2.svg">
                                    </div>
                                </td>
                                <td data-cell="head_control_two_score_2-5" class="table-custom-width head_control_two_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '2.5') selected-score @endif"></td>
                                <td data-cell="head_control_two_score_3" class="head_control_two_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '3') selected-score @endif">
                                    <p>raises head but head drops forward or back</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-control-flxor-3.svg">
                                    </div>
                                </td>
                                <td data-cell="head_control_two_score_3-5" class="table-custom-width head_control_two_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '3.5') selected-score @endif"></td>
                                <td data-cell="head_control_two_score_4" class="head_control_two_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '4') selected-score @endif">
                                    <p>raises head; head remains vertical, wobbles</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-control-flxor-4.svg">
                                    </div>
                                </td>
                                <td data-cell="head_control_two_score_4-5" class="table-custom-width head_control_two_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '4.5') selected-score @endif"></td>
                                <td data-cell="head_control_two_score_5" class="head_control_two_score_field @if(isset($hnne_details->head_control_2_score) && $hnne_details->head_control_2_score == '5') selected-score @endif">
                                    <p> head upright or extended; cannot be passively flexed </p>
                                    <div class="image-container"></div>
                                </td>
                                <td class="no-border" rowspan="2">
                                    <table class="table sub-table table-bordered head_control_two_score_table">
                                        <tr>
                                            <td class="head_control_two_score_valid_1_first_group">3</td>
                                            <td class="head_control_two_score_valid_1-5_first_group">0</td>
                                            <td class="head_control_two_score_valid_2_first_group">3</td>
                                            <td class="bg-secondary head_control_two_score_valid_2-5_first_group">5</td>
                                            <td class="bg-secondary head_control_two_score_valid_3_first_group">57</td>
                                            <td class="bg-secondary head_control_two_score_valid_3-5_first_group">11</td>
                                            <td class="bg-secondary head_control_two_score_valid_4_first_group">21</td>
                                            <td class="head_control_two_score_valid_4-5_first_group">0</td>
                                            <td class="head_control_two_score_valid_5_first_group">0</td>
                                            <td>
                                                <strong>25-27W</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="head_control_two_score_valid_1_second_group">1</td>
                                            <td class="head_control_two_score_valid_1-5_second_group">2</td>
                                            <td class="head_control_two_score_valid_2_second_group">6</td>
                                            <td class="bg-secondary head_control_two_score_valid_2-5_second_grou">4</td>
                                            <td class="bg-secondary head_control_two_score_valid_3_second_group">50</td>
                                            <td class="bg-secondary head_control_two_score_valid_3-5_second_group">13</td>
                                            <td class="bg-secondary head_control_two_score_valid_4_second_group">24</td>
                                            <td class="head_control_two_score_valid_4-5_second_group">0</td>
                                            <td class="head_control_two_score_valid_5_second_group">0</td>
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="head_control_two_score_valid_1_third_group">1</td>
                                            <td class="head_control_two_score_valid_1-5_third_group">0</td>
                                            <td class="head_control_two_score_valid_2_third_group">2</td>
                                            <td class="head_control_two_score_valid_2-5_third_group">2</td>
                                            <td class="bg-secondary head_control_two_score_valid_3_third_group">63</td>
                                            <td class="bg-secondary head_control_two_score_valid_3-5_third_group">11</td>
                                            <td class="bg-secondary head_control_two_score_valid_4_third_group">21</td>
                                            <td class="head_control_two_score_valid_4-5_third_group">0</td>
                                            <td class="head_control_two_score_valid_5_third_group">0</td>
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="head_control_two_score_valid_1_fourth_group">0</td>
                                            <td class="head_control_two_score_valid_1-5_fourth_group">0</td>
                                            <td class="head_control_two_score_valid_2_fourth_group">4</td>
                                            <td class="head_control_two_score_valid_2-5_fourth_group">2</td>
                                            <td class="bg-secondary head_control_two_score_valid_3_fourth_group">77</td>
                                            <td class="bg-secondary head_control_two_score_valid_3-5_fourth_group">2</td>
                                            <td class="bg-secondary head_control_two_score_valid_4_fourth_group">15</td>
                                            <td class="head_control_two_score_valid_4-5_fourth_group">0</td>
                                            <td class="head_control_two_score_valid_5_fourth_group">0</td>
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="head_control_two_score_valid_1_term_group">0</td>
                                            <td class="head_control_two_score_valid_1-5_term_group">0</td>
                                            <td class="head_control_two_score_valid_2_term_group">0</td>
                                            <td class="head_control_two_score_valid_2-5_term_group">4</td>
                                            <td class="bg-secondary head_control_two_score_valid_3_term_group">29</td>
                                            <td class="bg-secondary head_control_two_score_valid_3-5_term_group">15</td>
                                            <td class="bg-secondary head_control_two_score_valid_4_term_group">52</td>
                                            <td class="head_control_two_score_valid_4-5_term_group">0</td>
                                            <td class="head_control_two_score_valid_5_term_group">0</td>
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="added-info {{ $hnne_details->head_control_2_status == 2 ? '' : 'hide' }}" colspan="9">{!! $hnne_details->head_control_2_asymmetric !!} </td>
                            </tr>
                            <tr class="head-lag">
                                <td class="row-head" rowspan="2">
                                    <strong>HEAD LAG</strong>
                                </td>
                                <td data-cell="head_lag_score_1" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '1') selected-score @endif">
                                    <p> head drops back & stays </p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-lag-1.svg">
                                    </div>
                                </td>
                                <td data-cell="head_lag_score_1-5" class="table-custom-width head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '1.5') selected-score @endif"></td>
                                <td data-cell="head_lag_score_2" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '2') selected-score @endif">
                                    <p>tries to lift head but it drops back</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-lag-2.svg">
                                    </div>
                                </td>
                                <td data-cell="head_lag_score_2-5" class="table-custom-width head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '2.5') selected-score @endif"></td>
                                <td data-cell="head_lag_score_3" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '3') selected-score @endif">
                                    <p>able to lift head slightly</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-lag-3.svg">
                                    </div>
                                </td>
                                <td data-cell="head_lag_score_3-5" class="table-custom-width head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '3.5') selected-score @endif"></td>
                                <td data-cell="head_lag_score_4" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '4') selected-score @endif">
                                    <p>lifts head in line with body</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-lag-4.svg">
                                    </div>
                                </td>
                                <td data-cell="head_lag_score_4-5" class="table-custom-width head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '4.5') selected-score @endif"></td>
                                <td data-cell="head_lag_score_5" class="head_lag_score_field @if(isset($hnne_details->head_lag_score) && $hnne_details->head_lag_score == '5') selected-score @endif">
                                    <p> head in front of body </p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/head-lag-5.svg">
                                    </div>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                            <td>
                                                <strong>25-27W</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="added-info {{ $hnne_details->head_lag_status == 2 ? '' : 'hide' }}" colspan="9">{!! $hnne_details->head_lag_asymmetric !!} </td>
                            </tr>
                            <tr class="ventral-suspension">
                                <td class="row-head" align="center" rowspan="2">
                                    <strong>VENTRAL <br>SUSPENSION </strong>
                                </td>
                                <td data-cell="ventral_suspension_score_1" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '1') selected-score @endif">
                                    <p> back curved, head & limbs hang straight </p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/ventral-1.svg">
                                    </div>
                                </td>
                                <td data-cell="ventral_suspension_score_1-5" class="table-custom-width ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '1.5') selected-score @endif"></td>
                                <td data-cell="ventral_suspension_score_2" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '2') selected-score @endif">
                                    <p>back curved, head ↓, limbs slightly flexed</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/ventral-2.svg">
                                    </div>
                                </td>
                                <td data-cell="ventral_suspension_score_2-5" class="table-custom-width ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '2.5') selected-score @endif"></td>
                                <td data-cell="ventral_suspension_score_3" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '3') selected-score @endif">
                                    <p>back slightly curved, limbs flexed</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/ventral-3.svg">
                                    </div>
                                </td>
                                <td data-cell="ventral_suspension_score_3-5" class="table-custom-width ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '3.5') selected-score @endif"></td>
                                <td data-cell="ventral_suspension_score_4" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '4') selected-score @endif">
                                    <p>back straight, head in line, limbs flexed</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/ventral-4.svg">
                                    </div>
                                </td>
                                <td data-cell="ventral_suspension_score_4-5" class="table-custom-width ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '4.5') selected-score @endif"></td>
                                <td data-cell="ventral_suspension_score_5" class="ventral_suspension_score_field @if(isset($hnne_details->ventral_suspension_score) && $hnne_details->ventral_suspension_score == '5') selected-score @endif">
                                    <p> back straight, head above body, limbs flexed </p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/ventral-5.svg">
                                    </div>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                            <td>
                                                <strong>25-27W</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="added-info {{ $hnne_details->ventral_suspension_status == 2 ? '' : 'hide' }}" colspan="9">{!! $hnne_details->ventral_suspension_asymmetric !!} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hnnescreening2" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="11">
                                    <h4 class="m-0">
                                        <strong>Tone pattern items <span class="pull-right">{{ $hnne_details->tone_pattern_items }} / {{ $overall_score->tone_pattern_items }}</span></strong>
                                    </h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="flexor-tone">
                                <td class="row-head" rowspan="2">
                                    <strong>FLEXOR TONE <br>( compare arm <br>and leg traction ) </strong>
                                </td>
                                <td></td>
                                <td data-cell="flexor_tone_score_1-5" class="table-custom-width flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '1.5') selected-score @endif"></td>
                                <td data-cell="flexor_tone_score_2" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '2') selected-score @endif" align="center" valign="middle">
                                    <p>arm flexion <br>
                                        < <br> leg flexion
                                    </p>
                                </td>
                                <td data-cell="flexor_tone_score_2-5" class="table-custom-width flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '2.5') selected-score @endif"></td>
                                <td data-cell="flexor_tone_score_3" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '3') selected-score @endif">
                                    <p>arm flexion <br> = <br> leg flexion </p>
                                </td>
                                <td data-cell="flexor_tone_score_3-5" class="table-custom-width flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '3.5') selected-score @endif"></td>
                                <td data-cell="flexor_tone_score_4" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '4') selected-score @endif">
                                    <p>arm flexion <br> > <br> leg flexion: <br> difference &leq; 1 column </p>
                                </td>
                                <td data-cell="flexor_tone_score_4-5" class="table-custom-width flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '4.5') selected-score @endif"></td>
                                <td data-cell="flexor_tone_score_5" class="flexor_tone_score_field @if(isset($hnne_details->flexor_tone_score) && $hnne_details->flexor_tone_score == '5') selected-score @endif">
                                    <p>arm flexion <br> > <br> leg flexion: <br> difference > 1 column </p>
                                </td>
                                <td class="no-border" rowspan="2">
                                    <table class="table sub-table table-bordered flexor_tone_score_table">
                                        <tr>
                                            <td class="flexor_tone_score_valid_1_first_group">1</td>
                                            <td class="flexor_tone_score_valid_1-5_first_group">.5</td>
                                            <td class="flexor_tone_score_valid_2_first_group">2</td>
                                            <td class="flexor_tone_score_valid_2-5_first_group">.5</td>
                                            <td class="flexor_tone_score_valid_3_first_group">3</td>
                                            <td class="flexor_tone_score_valid_3-5_first_group">.5</td>
                                            <td class="flexor_tone_score_valid_4_first_group">4</td>
                                            <td class="flexor_tone_score_valid_4-5_first_group">.5</td>
                                            <td class="flexor_tone_score_valid_5_first_group">5</td>
                                        </tr>
                                        <tr>
                                            <td class="flexor_tone_score_valid_1_first_group">0</td>
                                            <td class="flexor_tone_score_valid_1-5_first_group">0</td>
                                            <td class="bg-secondary flexor_tone_score_valid_2_first_group">45</td>
                                            <td class="bg-secondary flexor_tone_score_valid_2-5_first_group">0</td>
                                            <td class="bg-secondary flexor_tone_score_valid_3_first_group">27</td>
                                            <td class="bg-secondary flexor_tone_score_valid_3-5_first_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary flexor_tone_score_valid_4_first_group">27</td>
                                            <td class="flexor_tone_score_valid_4-5_first_group">0</td>
                                            <td class="flexor_tone_score_valid_5_first_group">1</td>
                                            <td>
                                                <strong>25-27w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flexor_tone_score_valid_1_second_group">0</td>
                                            <td class="flexor_tone_score_valid_1-5_second_group">0</td>
                                            <td class="bg-secondary flexor_tone_score_valid_2_second_group">40</td>
                                            <td class="bg-secondary flexor_tone_score_valid_2-5_second_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary flexor_tone_score_valid_3_second_group">40</td>
                                            <td class="bg-secondary flexor_tone_score_valid_3-5_second_group">0</td>
                                            <td class="bg-secondary flexor_tone_score_valid_4_second_group">20</td>
                                            <td class="flexor_tone_score_valid_4-5_second_group">
                                                <1 
                                            </td>
                                            <td class="flexor_tone_score_valid_5_second_group">0</td>
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flexor_tone_score_valid_1_third_group">0</td>
                                            <td class="flexor_tone_score_valid_1-5_third_group">0</td>
                                            <td class="bg-secondary flexor_tone_score_valid_2_third_group">34</td>
                                            <td class="bg-secondary flexor_tone_score_valid_2-5_third_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary flexor_tone_score_valid_3_third_group">47</td>
                                            <td class="bg-secondary flexor_tone_score_valid_3-5_third_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary flexor_tone_score_valid_4_third_group">24</td>
                                            <td class="flexor_tone_score_valid_4-5_third_group">0</td>
                                            <td class="Flexor_tone_score_valid_5_third_group">1</td>
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flexor_tone_score_valid_1_fourth_group">0</td>
                                            <td class="flexor_tone_score_valid_1-5_fourth_group">0</td>
                                            <td class="bg-secondary flexor_tone_score_valid_2_fourth_group">38</td>
                                            <td class="bg-secondary flexor_tone_score_valid_2-5_fourth_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary flexor_tone_score_valid_3_fourth_group">36</td>
                                            <td class="bg-secondary flexor_tone_score_valid_3-5_fourth_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary flexor_tone_score_valid_4_fourth_group">24</td>
                                            <td class="flexor_tone_score_valid_4-5_fourth_group">
                                                <1 
                                            </td>
                                            <td class="flexor_tone_score_valid_5_fourth_group">2</td>
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td class="flexor_tone_score_valid_5_term_group">
                                                <1 
                                            </td>
                                            <td style="white-space: nowrap;">
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" class="added-info {{ $hnne_details->flexor_tone_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->flexor_tone_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="resting-posture">
                                <td class="row-head" rowspan="2">
                                    <strong>FLEXOR TONE <br>( resting posture ) </strong>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td data-cell="flexor_tone_resting_posture_score_2-5" class="table-custom-width flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '2.5') selected-score @endif"></td>
                                <td data-cell="flexor_tone_resting_posture_score_3" class="flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '3') selected-score @endif">
                                    <p>arms and <br> legs generally flexed </p>
                                </td>
                                <td data-cell="flexor_tone_resting_posture_score_3-5" class="table-custom-width flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '3.5') selected-score @endif"></td>
                                <td data-cell="flexor_tone_resting_posture_score_4" class="flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '4') selected-score @endif">
                                    <p>strong arm flexion with strong leg extension <i>intermittent</i>
                                    </p>
                                </td>
                                <td data-cell="flexor_tone_resting_posture_score_4-5" class="table-custom-width flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '4.5') selected-score @endif"></td>
                                <td data-cell="flexor_tone_resting_posture_score_5" class="flexor_tone_resting_posture_score_field @if(isset($hnne_details->flexor_tone_resting_posture_score) && $hnne_details->flexor_tone_resting_posture_score == '5') selected-score @endif">
                                    <p>strong arm flexion with strong leg extension <i>continuous</i>
                                    </p>
                                </td>
                                <td class="no-border" rowspan="2">
                                    <table class="table sub-table table-bordered flexor_tone_resting_posture_score_table">
                                        <tr>
                                            <td class="flexor_tone_resting_posture_score_valid_1_first_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_1-5_first_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_2_first_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_2-5_first_group">0</td>
                                            <td class="bg-secondary flexor_tone_resting_posture_score_valid_3_first_group">99</td>
                                            <td class="flexor_tone_resting_posture_score_valid_3-5_first_group">
                                                <1 
                                            </td>
                                            <td class="flexor_tone_resting_posture_score_valid_4_first_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_4-5_first_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_5_first_group">1</td>
                                            <td>
                                                <strong>25-27w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flexor_tone_resting_posture_score_valid_1_second_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_1-5_second_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_2_second_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_2-5_second_group">0</td>
                                            <td class="bg-secondary flexor_tone_resting_posture_score_valid_3_second_group">96</td>
                                            <td class="flexor_tone_resting_posture_score_valid_3-5_second_group">
                                                <1 
                                            </td>
                                            <td class="flexor_tone_resting_posture_score_valid_4_second_group">3</td>
                                            <td class="flexor_tone_resting_posture_score_valid_4-5_second_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_5_second_group">1</td>
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flexor_tone_resting_posture_score_valid_1_third_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_1-5_third_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_2_third_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_2-5_third_group">0</td>
                                            <td class="bg-secondary flexor_tone_resting_posture_score_valid_3_third_group">96</td>
                                            <td class="flexor_tone_resting_posture_score_valid_3-5_third_group">
                                                <1 
                                            </td>
                                            <td class="flexor_tone_resting_posture_score_valid_4_third_group">2</td>
                                            <td class="flexor_tone_resting_posture_score_valid_4-5_third_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_5_third_group">2</td>
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flexor_tone_resting_posture_score_valid_1_fourth_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_1-5_fourth_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_2_fourth_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_2-5_fourth_group">0</td>
                                            <td class="bg-secondary flexor_tone_resting_posture_score_valid_3_fourth_group">94</td>
                                            <td class="flexor_tone_resting_posture_score_valid_3-5_fourth_group">
                                                <1 
                                            </td>
                                            <td class="flexor_tone_resting_posture_score_valid_4_fourth_group">2</td>
                                            <td class="flexor_tone_resting_posture_score_valid_4-5_fourth_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_5_fourth_group">4</td>
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="flexor_tone_resting_posture_score_valid_1_term_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_1-5_term_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_2_term_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_2-5_term_group">0</td>
                                            <td class="bg-secondary flexor_tone_resting_posture_score_valid_3_term_group">99</td>
                                            <td class="flexor_tone_resting_posture_score_valid_3-5_term_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_4_term_group">
                                                <1 
                                            </td>
                                            <td class="flexor_tone_resting_posture_score_valid_4-5_term_group">0</td>
                                            <td class="flexor_tone_resting_posture_score_valid_5_term_group">
                                                <1 
                                            </td>
                                            <td>
                                                <strong>Full Term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" class="added-info {{ $hnne_details->flexor_tone_resting_posture_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->flexor_tone_resting_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="leg-tone">
                                <td class="row-head" rowspan="2">
                                    <strong>LEG TONE <br>( leg traction and <br>popliteal angle ) </strong>
                                </td>
                                <td></td>
                                <td data-cell="leg_tone_score_1-5" class="table-custom-width leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '1.5') selected-score @endif"></td>
                                <td data-cell="leg_tone_score_2" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '2') selected-score @endif">
                                    <p>leg traction > popliteal angle</p>
                                </td>
                                <td data-cell="leg_tone_score_2-5" class="table-custom-width leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '2.5') selected-score @endif"></td>
                                <td data-cell="leg_tone_score_3" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '3') selected-score @endif">
                                    <p>leg traction = popliteal angle</p>
                                </td>
                                <td data-cell="leg_tone_score_3-5" class="table-custom-width leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '3.5') selected-score @endif"></td>
                                <td data-cell="leg_tone_score_4" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '4') selected-score @endif">
                                    <p>leg traction < popliteal angle; <br>difference &leq;1 column </p>
                                </td>
                                <td data-cell="leg_tone_score_4-5" class="table-custom-width leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '4.5') selected-score @endif"></td>
                                <td data-cell="leg_tone_score_5" class="leg_tone_score_field @if(isset($hnne_details->leg_tone_score) && $hnne_details->leg_tone_score == '5') selected-score @endif">
                                    <p>leg traction < popliteal angle; <br>difference >1 column </p>
                                </td>
                                <td class="no-border" rowspan="2">
                                    <table class="table sub-table table-bordered leg_tone_score_table">
                                        <tr>
                                            <td class="leg_tone_score_valid_1_first_group">0</td>
                                            <td class="leg_tone_score_valid_1-5_first_group">0</td>
                                            <td class="bg-secondary leg_tone_score_valid_2_first_group">43</td>
                                            <td class="bg-secondary leg_tone_score_valid_2-5_first_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary leg_tone_score_valid_3_first_group">34</td>
                                            <td class="bg-secondary leg_tone_score_valid_3-5_first_group">0</td>
                                            <td class="bg-secondary leg_tone_score_valid_4_first_group">21</td>
                                            <td class="leg_tone_score_valid_4-5_first_group">
                                                <1 
                                            </td>
                                            <td class="leg_tone_score_valid_5_first_group">1</td>
                                            <td>
                                                <strong>25-27w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="leg_tone_score_valid_1_second_group">0</td>
                                            <td class="leg_tone_score_valid_1-5_second_group">0</td>
                                            <td class="bg-secondary leg_tone_score_valid_2_second_group">41</td>
                                            <td class="bg-secondary leg_tone_score_valid_2-5_second_group">0</td>
                                            <td class="bg-secondary leg_tone_score_valid_3_second_group">39</td>
                                            <td class="bg-secondary leg_tone_score_valid_3-5_second_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary leg_tone_score_valid_4_second_group">19</td>
                                            <td class="leg_tone_score_valid_4-5_second_group">0</td>
                                            <td class="leg_tone_score_valid_5_second_group">1</td>
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="leg_tone_score_valid_1_third_group">0</td>
                                            <td class="leg_tone_score_valid_1-5_third_group">0</td>
                                            <td class="bg-secondary leg_tone_score_valid_2_third_group">38</td>
                                            <td class="bg-secondary leg_tone_score_valid_2-5_third_group">0</td>
                                            <td class="bg-secondary leg_tone_score_valid_3_third_group">36</td>
                                            <td class="bg-secondary leg_tone_score_valid_3-5_third_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary leg_tone_score_valid_4_third_group">22</td>
                                            <td class="leg_tone_score_valid_4-5_third_group">
                                                <1 
                                            </td>
                                            <td class="leg_tone_score_valid_5_third_group">4</td>
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="leg_tone_score_valid_1_fourth_group">0</td>
                                            <td class="leg_tone_score_valid_1-5_fourth_group">0</td>
                                            <td class="bg-secondary leg_tone_score_valid_2_fourth_group">19</td>
                                            <td class="bg-secondary leg_tone_score_valid_2-5_fourth_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary leg_tone_score_valid_3_fourth_group">50</td>
                                            <td class="bg-secondary leg_tone_score_valid_3-5_fourth_group">
                                                <1 
                                            </td>
                                            <td class="bg-secondary leg_tone_score_valid_4_fourth_group">29</td>
                                            <td class="leg_tone_score_valid_4-5_fourth_group">
                                                <1 
                                            </td>
                                            <td class="leg_tone_score_valid_5_fourth_group">2</td>
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td>
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" class="added-info {{ $hnne_details->leg_tone_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->leg_tone_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="head-control-sitting">
                                <td class="row-head" rowspan="2">
                                    <strong>HEAD CONTROL <br>( sitting ) </strong>
                                </td>
                                <td></td>
                                <td data-cell="head_control_sitting_score_1-5" class="table-custom-width head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '1.5') selected-score @endif"></td>
                                <td data-cell="head_control_sitting_score_2" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '2') selected-score @endif">
                                    <p>neck extension < neck flexion </p>
                                </td>
                                <td data-cell="head_control_sitting_score_2-5" class="table-custom-width head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '2.5') selected-score @endif"></td>
                                <td data-cell="head_control_sitting_score_3" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '3') selected-score @endif">
                                    <p>neck extension = neck flexion</p>
                                </td>
                                <td data-cell="head_control_sitting_score_3-5" class="table-custom-width head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '3.5') selected-score @endif"></td>
                                <td data-cell="head_control_sitting_score_4" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '4') selected-score @endif">
                                    <p>neck extension > neck flexion <br>difference &leq; 1 column </p>
                                </td>
                                <td data-cell="head_control_sitting_score_4-5" class="table-custom-width head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '4.5') selected-score @endif"></td>
                                <td data-cell="head_control_sitting_score_5" class="head_control_sitting_score_field @if(isset($hnne_details->head_control_sitting_score) && $hnne_details->head_control_sitting_score == '5') selected-score @endif">
                                    <p>neck extension > neck flexion <br>difference > 1 column </p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                            <td>
                                                <strong>25-27w</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td class="head_control_sitting_score_valid_5_term_group">
                                                <1 
                                            </td>
                                            <td>
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" class="added-info {{ $hnne_details->head_control_sitting_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->head_control_sitting_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="neck-axial-tone">
                                <td class="row-head" rowspan="2">
                                    <strong>NECK AND <br>AXIAL TONE <br>( horizontal ) </strong>
                                </td>
                                <td></td>
                                <td data-cell="neck_axial_tone_score_1-5" class="table-custom-width neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '1.5') selected-score @endif"></td>
                                <td data-cell="neck_axial_tone_score_2" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '2') selected-score @endif">
                                    <p>ventral suspension < head lag </p>
                                </td>
                                <td data-cell="neck_axial_tone_score_2-5" class="table-custom-width neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '2.5') selected-score @endif"></td>
                                <td data-cell="neck_axial_tone_score_3" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '3') selected-score @endif">
                                    <p>ventral suspension = head lag</p>
                                </td>
                                <td data-cell="neck_axial_tone_score_3-5" class="table-custom-width neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '3.5') selected-score @endif"></td>
                                <td data-cell="neck_axial_tone_score_4" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '4') selected-score @endif">
                                    <p>ventral suspension > head lag <br>difference &leq; 1 column </p>
                                </td>
                                <td data-cell="neck_axial_tone_score_4-5" class="table-custom-width neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '4.5') selected-score @endif"></td>
                                <td data-cell="neck_axial_tone_score_5" class="neck_axial_tone_score_field @if(isset($hnne_details->neck_axial_tone_score) && $hnne_details->neck_axial_tone_score == '5') selected-score @endif">
                                    <p>ventral suspension > head lag <br>difference > 1 column </p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                            <td>
                                                <strong>25-27w</strong>
                                            </td>
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
                                            <td>
                                                <strong>28-29w</strong>
                                            </td>
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
                                            <td>
                                                <strong>30-31w</strong>
                                            </td>
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
                                            <td>
                                                <strong>32-34w</strong>
                                            </td>
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
                                            <td class="neck_axial_tone_score_valid_5_term_group">
                                                <1 
                                            </td>
                                            <td>
                                                <strong>Full term</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" class="added-info {{ $hnne_details->neck_axial_tone_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->neck_axial_tone_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hnnescreening3" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="11">
                                    <h4 class="m-0"><strong>Reflex items <span class="pull-right">{{ $hnne_details->reflex_items }} / {{ $overall_score->reflex_items }}</span></strong></h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tendon-reflex">
                                <td class="row-head" rowspan="2">
                                    <strong>TENDON REFLEX</strong>
                                </td>
                                <td  data-cell="tendon_reflex_score_1" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>absent</p>
                                </td>
                                <td  data-cell="tendon_reflex_score_1-5" class="table-custom-width tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="tendon_reflex_score_2" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '2') selected-score @endif">
                                    <p>felt, not seen</p>
                                </td>
                                <td  data-cell="tendon_reflex_score_2-5" class="table-custom-width tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="tendon_reflex_score_3" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '3') selected-score @endif">
                                    <p>seen</p>
                                </td>
                                <td  data-cell="tendon_reflex_score_3-5" class="table-custom-width tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="tendon_reflex_score_4" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '4') selected-score @endif">
                                    <p>'exaggerated'</p>
                                </td>
                                <td  data-cell="tendon_reflex_score_4-5" class="table-custom-width tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="tendon_reflex_score_5" class="tendon_reflex_score_field @if(isset($hnne_details->tendon_reflex_score) && $hnne_details->tendon_reflex_score == '5') selected-score @endif">
                                    <p>clonus</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->tendon_reflex_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->tendon_reflex_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="suck-gag">
                                <td class="row-head" rowspan="2">
                                    <strong>SUCK / GAG</strong>
                                </td>
                                <td  data-cell="suck_gag_score_1" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>no gag / no suck</p>
                                </td>
                                <td  data-cell="suck_gag_score_1-5" class="table-custom-width suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="suck_gag_score_2" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '2') selected-score @endif">
                                    <p>weak irregular suck only:</p>
                                    <p>no stripping</p>
                                </td>
                                <td  data-cell="suck_gag_score_2-5" class="table-custom-width suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="suck_gag_score_3" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '3') selected-score @endif">
                                    <p>weak regular suck </p>
                                    <p>some stripping</p>
                                </td>
                                <td  data-cell="suck_gag_score_3-5" class="table-custom-width suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="suck_gag_score_4" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '4') selected-score @endif">
                                    <p>strong suck <br>(a) irregular <br>(b) regular</p>
                                    <p>good stripping</p>
                                </td>
                                <td  data-cell="suck_gag_score_4-5" class="table-custom-width suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="suck_gag_score_5" class="suck_gag_score_field @if(isset($hnne_details->suck_gag_score) && $hnne_details->suck_gag_score == '5') selected-score @endif">
                                    <p>no suck but strong clenching</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->suck_gag_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->suck_gag_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="palmar-grasp">
                                <td class="row-head" rowspan="2">
                                    <strong>PALMAR <br>GRASP</strong>
                                </td>
                                <td  data-cell="palmar_grasp_score_1" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>no response</p>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td  data-cell="palmar_grasp_score_1-5" class="table-custom-width palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="palmar_grasp_score_2" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '2') selected-score @endif">
                                    <p>short weak flexion fingers</p>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td  data-cell="palmar_grasp_score_2-5" class="table-custom-width palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="palmar_grasp_score_3" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '3') selected-score @endif">
                                    <p>strong flexion of fingers</p>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td  data-cell="palmar_grasp_score_3-5" class="table-custom-width palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="palmar_grasp_score_4" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '4') selected-score @endif">
                                    <p>very strong flexion fingers, shoulder</p><i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td  data-cell="palmar_grasp_score_4-5" class="table-custom-width palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="palmar_grasp_score_5" class="palmar_grasp_score_field @if(isset($hnne_details->palmar_grasp_score) && $hnne_details->palmar_grasp_score == '5') selected-score @endif">
                                    <p>very strong grasp; infant can be lifted off couch</p>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->palmar_grasp_status == 2 ? '' : 'hide' }} added-info">                   
                                    {!! $hnne_details->palmar_grasp_asymmetric!!}
                                </td>
                            </tr>
                            <tr class="plantar-grasp">
                                <td class="row-head" rowspan="2">
                                    <strong>PLANTAR <br>GRASP</strong>
                                </td>
                                <td  data-cell="plantar_grasp_score_1" class="plantar_grasp_score_field @if(isset($hnne_details->plantar_grasp_score) && $hnne_details->plantar_grasp_score == '1') selected-score @endif " align="center" valign="middle">
                                    <p>no response</p>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td  data-cell="plantar_grasp_score_1-5" class="table-custom-width plantar_grasp_score_field @if(isset($hnne_details->plantar_grasp_score) && $hnne_details->plantar_grasp_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="plantar_grasp_score_2" class="plantar_grasp_score_field @if(isset($hnne_details->plantar_grasp_score) && $hnne_details->plantar_grasp_score == '2') selected-score @endif ">
                                    <p>partial plantat flexion of toes</p>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td  data-cell="plantar_grasp_score_2-5" class="table-custom-width plantar_grasp_score_field @if(isset($hnne_details->plantar_grasp_score) && $hnne_details->plantar_grasp_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="plantar_grasp_score_3" class="plantar_grasp_score_field @if(isset($hnne_details->plantar_grasp_score) && $hnne_details->plantar_grasp_score == '3') selected-score @endif ">
                                    <p>toes curve around the examiner's finger</p>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td class="table-custom-width"></td>
                                <td ></td>
                                <td class="table-custom-width"></td>
                                <td ></td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->plantar_grasp_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->plantar_grasp_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="placing">
                                <td class="row-head" rowspan="2">
                                    <strong>PLACING</strong>
                                </td>
                                <td  data-cell="placing_score_1" class="placing_score_field @if(isset($hnne_details->placing_score) && $hnne_details->placing_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>no response</p>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td  data-cell="placing_score_1-5" class="table-custom-width placing_score_field @if(isset($hnne_details->placing_score) && $hnne_details->placing_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="placing_score_2" class="placing_score_field @if(isset($hnne_details->placing_score) && $hnne_details->placing_score == '2') selected-score @endif">
                                    <p>dorsi flexion of ankle only</p>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td  data-cell="placing_score_2-5" class="table-custom-width placing_score_field @if(isset($hnne_details->placing_score) && $hnne_details->placing_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="placing_score_3" class="placing_score_field @if(isset($hnne_details->placing_score) && $hnne_details->placing_score == '3') selected-score @endif">
                                    <p>full placing response with flexion of hip, knee & placing sole on surface</p>
                                    <br>
                                    <div>
                                        <span class="pull-left">R</span>
                                        <span class="pull-right">L</span>
                                    </div>
                                </td>
                                <td class="table-custom-width"></td>
                                <td ></td>
                                <td class="table-custom-width"></td>
                                <td ></td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->placing_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->placing_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="moro-reflex">
                                <td class="row-head" rowspan="2">
                                    <strong>MORO REFLEX</strong>
                                </td>
                                <td  data-cell="moro_reflex_score_1" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '1') selected-score @endif" align="center">
                                    <p>no response or opening of hands only</p>
                                </td>
                                <td  data-cell="moro_reflex_score_1-5" class="table-custom-width moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="moro_reflex_score_2" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '2') selected-score @endif" style="vertical-align: top !important;">
                                    <p>full abduction at shoulder and extension of the arms: no adduction</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/moro-reflex-2.svg">
                                    </div>
                                </td>
                                <td  data-cell="moro_reflex_score_2-5" class="table-custom-width moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="moro_reflex_score_3" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '3') selected-score @endif" style="vertical-align: top !important;">
                                    <p>full abduction but only delayed or partial adduction</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/moro-reflex-3.svg">
                                    </div>
                                </td>
                                <td  data-cell="moro_reflex_score_3-5" class="table-custom-width moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="moro_reflex_score_4" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '4') selected-score @endif" style="vertical-align: top !important;">
                                    <p>partial abduction at shoulder and extension of arms followed by smooth adduction</p>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/moro-reflex-4.svg">
                                    </div>
                                </td>
                                <td  data-cell="moro_reflex_score_4-5" class="table-custom-width moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="moro_reflex_score_5" class="moro_reflex_score_field @if(isset($hnne_details->moro_reflex_score) && $hnne_details->moro_reflex_score == '5') selected-score @endif">
                                    <ul class="table-list">
                                        <li>no abduction or adduction; </li>
                                        <li>only forward extension of arms from the shoulders</li>
                                        <li>marked adduction only</li>
                                    </ul>
                                    <div class="image-container">
                                        <img src="{{ url('/') }}/public/img/hnne/moro-reflex-5.svg">
                                    </div>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                <td colspan="9" class="{{ $hnne_details->moro_reflex_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->moro_reflex_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hnnescreening4" class="assessment-page-break mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="11">
                                    <h4 class="m-0"><strong>Movements  <span class="pull-right">{{ $hnne_details->movements }} / {{ $overall_score->movements }}</span></strong></h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="spontaneous-movements">
                                <td class="row-head" rowspan="2">
                                    <strong>SPONTANEOUS <br>MOVEMENTS ( quantity )</strong>
                                </td>
                                <td  data-cell="spontaneous_movements_score_1" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>no movement</p>
                                </td>
                                <td  data-cell="spontaneous_movements_score_1-5" class="table-custom-width spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="spontaneous_movements_score_2" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '2') selected-score @endif">
                                    <p>sporadic and short isolated movements</p>
                                </td>
                                <td  data-cell="spontaneous_movements_score_2-5" class="table-custom-width spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="spontaneous_movements_score_3" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '3') selected-score @endif">
                                    <p>frequent isolated movements</p>
                                </td>
                                <td  data-cell="spontaneous_movements_score_3-5" class="table-custom-width spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="spontaneous_movements_score_4" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '4') selected-score @endif">
                                    <p>frequent generalized movements</p>
                                </td>
                                <td  data-cell="spontaneous_movements_score_4-5" class="table-custom-width spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="spontaneous_movements_score_5" class="spontaneous_movements_score_field @if(isset($hnne_details->spontaneous_movements_score) && $hnne_details->spontaneous_movements_score == '5') selected-score @endif">
                                    <p>continuous exaggerated movements</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->spontaneous_movements_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->spontaneous_movements_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="spontaneous-movements-quality">
                                <td class="row-head" rowspan="2">
                                    <strong>SPONTANEOUS <br>MOVEMENTS ( quality )</strong>
                                </td>
                                <td  data-cell="spontaneous_movements_quality_score_1" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>only stretches</p>
                                </td>
                                <td  data-cell="spontaneous_movements_quality_score_1-5" class="table-custom-width spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="spontaneous_movements_quality_score_2" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '2') selected-score @endif">
                                    <p>stretches and random abrupt movements</p>
                                    <p>Some smooth movements</p>
                                </td>
                                <td  data-cell="spontaneous_movements_quality_score_2-5" class="table-custom-width spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="spontaneous_movements_quality_score_3" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '3') selected-score @endif">
                                    <p>fluent movements but monotonous</p>
                                </td>
                                <td  data-cell="spontaneous_movements_quality_score_3-5" class="table-custom-width spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="spontaneous_movements_quality_score_4" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '4') selected-score @endif">
                                    <p>fluent alternating movements of arms + legs;</p>
                                    <p>good variability</p>
                                </td>
                                <td  data-cell="spontaneous_movements_quality_score_4-5" class="table-custom-width spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="spontaneous_movements_quality_score_5" class="spontaneous_movements_quality_score_field @if(isset($hnne_details->spontaneous_movements_quality_score) && $hnne_details->spontaneous_movements_quality_score == '5') selected-score @endif">
                                    <p>cramped synchronous</p>
                                    <p>mouthing</p>
                                    <p>jerky or other abnormal movements</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->spontaneous_movements_quality_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->spontaneous_movements_quality_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="head-raising">
                                <td class="row-head" rowspan="2">
                                    <strong>HEAD RAISING</strong>
                                </td>
                                <td  data-cell="head_raising_score_1" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>no movements</p>
                                </td>
                                <td  data-cell="head_raising_score_1-5" class="table-custom-width head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="head_raising_score_2" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '2') selected-score @endif">
                                    <p>infant rolls head over, chin not raised</p>
                                </td>
                                <td  data-cell="head_raising_score_2-5" class="table-custom-width head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="head_raising_score_3" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '3') selected-score @endif">
                                    <p>infant raises chin, rolls head over</p>
                                </td>
                                <td  data-cell="head_raising_score_3-5" class="table-custom-width head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="head_raising_score_4" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '4') selected-score @endif">
                                    <p>infant brings head and chin up</p>
                                </td>
                                <td  data-cell="head_raising_score_4-5" class="table-custom-width head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="head_raising_score_5" class="head_raising_score_field @if(isset($hnne_details->head_raising_score) && $hnne_details->head_raising_score == '5') selected-score @endif">
                                    <p>infant brings head up and keeps it up</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                <td colspan="9" class="{{ $hnne_details->head_raising_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->head_raising_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hnnescreening5" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="11">
                                    <h4 class="m-0"><strong>Abnormal signs <span class="pull-right">{{ $hnne_details->abnormal_signs }} / {{ $overall_score->abnormal_signs }}</span></strong></h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="abn-hand-toe-postures">
                                <td class="row-head" rowspan="2">
                                    <strong>ABN.HAND OR TOE <br>POSTURES</strong>
                                </td>
                                <td></td>
                                <td class="table-custom-width"></td>
                                <td  data-cell="abn_hand_toe_postures_score_2" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '2') selected-score @endif">
                                    <p>hands open toes straight most of the time</p>
                                </td>
                                <td  data-cell="abn_hand_toe_postures_score_2-5" class="table-custom-width abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="abn_hand_toe_postures_score_3" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '3') selected-score @endif">
                                    <p>intermittent fisting or thumb adduction</p>
                                </td>
                                <td  data-cell="abn_hand_toe_postures_score_3-5" class="table-custom-width abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="abn_hand_toe_postures_score_4" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '4') selected-score @endif">
                                    <p>continuous fisting or thumb adduction; index finger flexion, thumb opposition</p>
                                </td>
                                <td  data-cell="abn_hand_toe_postures_score_4-5" class="table-custom-width abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="abn_hand_toe_postures_score_5" class="abn_hand_toe_postures_score_field @if(isset($hnne_details->abn_hand_toe_postures_score) && $hnne_details->abn_hand_toe_postures_score == '5') selected-score @endif">
                                    <p>continuous big toe  extension or flexion of all toes</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->abn_hand_toe_postures_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->abn_hand_toe_postures_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="tremor">
                                <td class="row-head" rowspan="2">
                                    <strong>TREMOR</strong>
                                </td>
                                <td ></td>
                                <td class="table-custom-width"></td>
                                <td  data-cell="tremor_score_2" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '2') selected-score @endif">
                                    <p>no tremor or tremor or only when crying</p>
                                </td>
                                <td  data-cell="tremor_score_2-5" class="table-custom-width tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="tremor_score_3" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '3') selected-score @endif">
                                    <p>tremor only after Moro or occasionally when awake</p>
                                </td>
                                <td  data-cell="tremor_score_3-5" class="table-custom-width tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="tremor_score_4" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '4') selected-score @endif">
                                    <p>frequent tremors when awake</p>
                                </td>
                                <td  data-cell="tremor_score_4-5" class="table-custom-width tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="tremor_score_5" class="tremor_score_field @if(isset($hnne_details->tremor_score) && $hnne_details->tremor_score == '5') selected-score @endif">
                                    <p>continuous tremors</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->tremor_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->tremor_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="startle">
                                <td class="row-head" rowspan="2">
                                    <strong>STARTLE</strong>
                                </td>
                                <td  data-cell="startle_score_1" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>no startle even to sudden noise</p>
                                </td>
                                <td  data-cell="startle_score_1-5" class="table-custom-width startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="startle_score_2" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '2') selected-score @endif">
                                    <p>no spontaneous startle but reacts to sudden noise</p>
                                </td>
                                <td  data-cell="startle_score_2-5" class="table-custom-width startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="startle_score_3" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '3') selected-score @endif">
                                    <p>2-3 spontaneous startle</p>
                                </td>
                                <td  data-cell="startle_score_3-5" class="table-custom-width startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="startle_score_4" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '4') selected-score @endif">
                                    <p>more than 3 spontaneous startle</p>
                                </td>
                                <td  data-cell="startle_score_4-5" class="table-custom-width startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="startle_score_5" class="startle_score_field @if(isset($hnne_details->startle_score) && $hnne_details->startle_score == '5') selected-score @endif">
                                    <p>continuous startle</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                <td colspan="9" class="{{ $hnne_details->startle_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->startle_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hnnescreening6" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="11">
                                    <h4 class="m-0"><strong>Behavioural signs, vision, hearing <span class="pull-right">{{ $hnne_details->behavioural_signs }} / {{ $overall_score->behavioural_signs }}</span></strong></h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="eye-appearance">
                                <td class="row-head" rowspan="2">
                                    <strong>EYE APPEARARANCE</strong>
                                </td>
                                <td  data-cell="eye_appearance_score_1" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '1') selected-score @endif">
                                    <p>does not open eyes</p>
                                </td>
                                <td  data-cell="eye_appearance_score_1-5" class="table-custom-width eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '1.5') selected-score @endif"></td>
                                <td ></td>
                                <td  data-cell="eye_appearance_score_2-5" class="table-custom-width eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="eye_appearance_score_3" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '3') selected-score @endif">
                                    <p>full conjugated eye move</p>
                                </td>
                                <td  data-cell="eye_appearance_score_2-5" class="table-custom-width eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="eye_appearance_score_4" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '4') selected-score @endif">
                                    <p>trasient</p>
                                    <p>nystagmus</p>
                                    <p>strabismus</p>
                                    <p>roving eye movements</p>
                                    <p>sunsetting sign</p>
                                </td>
                                <td  data-cell="eye_appearance_score_4-5" class="table-custom-width eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="eye_appearance_score_5" class="eye_appearance_score_field @if(isset($hnne_details->eye_appearance_score) && $hnne_details->eye_appearance_score == '5') selected-score @endif">
                                    <p>persistent</p>
                                    <p>nystagmus</p>
                                    <p>strabismus</p>
                                    <p>roving eye movements</p>
                                    <p>downward deviation</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->eye_appearance_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->eye_appearance_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="auditory-orientation">
                                <td class="row-head" rowspan="2">
                                    <strong>AUDITORY ORIENTATION</strong>
                                </td>
                                <td  data-cell="auditory_orientation_score_1" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '1') selected-score @endif">
                                    <p>no reaction</p>
                                </td>
                                <td  data-cell="auditory_orientation_score_1-5" class="table-custom-width auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="auditory_orientation_score_2" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '2') selected-score @endif">
                                    <p>auditory startle; Brightness and stills;</p>
                                    <p>no true orientation</p>
                                </td>
                                <td  data-cell="auditory_orientation_score_2-5" class="table-custom-width auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="auditory_orientation_score_3" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '3') selected-score @endif">
                                    <p>shifting of eyes, head might turn towards source</p>
                                </td>
                                <td  data-cell="auditory_orientation_score_3-5" class="table-custom-width auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="auditory_orientation_score_4" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '4') selected-score @endif">
                                    <p>prolonged head turn to stimulus;</p>
                                    <p>search with eyes</p>
                                    <p>smooth</p>
                                </td>
                                <td  data-cell="auditory_orientation_score_4-5" class="table-custom-width auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="auditory_orientation_score_5" class="auditory_orientation_score_field @if(isset($hnne_details->auditory_orientation_score) && $hnne_details->auditory_orientation_score == '5') selected-score @endif">
                                    <p>truns head and eyes towards noise erery time;</p>
                                    <p>jerky abrupt</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->auditory_orientation_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->auditory_orientation_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="visual-orientation">
                                <td class="row-head" rowspan="2">
                                    <strong>VISUAL ORIENTATION</strong>
                                </td>
                                <td  data-cell="visual_orientation_score_1" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>does not follow or focus on stimuli</p>
                                </td>
                                <td  data-cell="visual_orientation_score_1-5" class="table-custom-width visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="visual_orientation_score_2" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '2') selected-score @endif">
                                    <p>stills, focuses follows briefly to the side but loses stimuli</p>
                                </td>
                                <td  data-cell="visual_orientation_score_2-5" class="table-custom-width visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="visual_orientation_score_3" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '3') selected-score @endif">
                                    <p>follows horizontally and vertivcally;</p>
                                    <p>no head turn</p>
                                </td>
                                <td  data-cell="visual_orientation_score_3-5" class="table-custom-width visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="visual_orientation_score_4" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '4') selected-score @endif">
                                    <p>follows horizontally and vertivcally;</p>
                                    <p>head turn</p>
                                </td>
                                <td  data-cell="visual_orientation_score_4-5" class="table-custom-width visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="visual_orientation_score_5" class="visual_orientation_score_field @if(isset($hnne_details->visual_orientation_score) && $hnne_details->visual_orientation_score == '5') selected-score @endif">
                                    <p>follows in a circle</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->visual_orientation_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->visual_orientation_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="alertness">
                                <td class="row-head" rowspan="2">
                                    <strong>ALERTNESS</strong>
                                </td>
                                <td  data-cell="alertness_score_1" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>will not respond to stimuli</p>
                                </td>
                                <td  data-cell="alertness_score_1-5" class="table-custom-width alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="alertness_score_2" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '2') selected-score @endif">
                                    <p>when awake, looks only briefly</p>
                                </td>
                                <td  data-cell="alertness_score_2-5" class="table-custom-width alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="alertness_score_3" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '3') selected-score @endif">
                                    <p>when awake, looks at stimuli but loses them</p>
                                </td>
                                <td  data-cell="alertness_score_3-5" class="table-custom-width alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="alertness_score_4" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '4') selected-score @endif">
                                    <p>keep interset in stimuli</p>
                                </td>
                                <td  data-cell="alertness_score_4-5" class="table-custom-width alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="alertness_score_5" class="alertness_score_field @if(isset($hnne_details->alertness_score) && $hnne_details->alertness_score == '5') selected-score @endif">
                                    <p>does not tire (hyper-reactive)</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->alertness_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->alertness_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="irritability">
                                <td class="row-head" rowspan="2">
                                    <strong>IRRITABILITY</strong>
                                </td>
                                <td  data-cell="irritability_score_1" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>quiet all the time, not irritable to any stimuli</p>
                                </td>
                                <td  data-cell="irritability_score_1-5" class="table-custom-width irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="irritability_score_2" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '2') selected-score @endif">
                                    <p>awakes, cries sometimes when handled</p>
                                </td>
                                <td  data-cell="irritability_score_2-5" class="table-custom-width irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="irritability_score_3" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '3') selected-score @endif">
                                    <p>cries often when handled</p>
                                </td>
                                <td  data-cell="irritability_score_3-5" class="table-custom-width irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="irritability_score_4" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '4') selected-score @endif">
                                    <p>cries always when handled</p>
                                </td>
                                <td  data-cell="irritability_score_4-5" class="table-custom-width irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="irritability_score_5" class="irritability_score_field @if(isset($hnne_details->irritability_score) && $hnne_details->irritability_score == '5') selected-score @endif">
                                    <p>cries even when not handled</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->irritability_status == 2 ? '' : 'hide' }} added-info">           
                                    {!! $hnne_details->irritability_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="consolability">
                                <td class="row-head" rowspan="2">
                                    <strong>CONSOLABILITY</strong>
                                </td>
                                <td  data-cell="consolability_score_1" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>not crying consoling not needed</p>
                                </td>
                                <td  data-cell="consolability_score_1-5" class="table-custom-width consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="consolability_score_2" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '2') selected-score @endif">
                                    <p>cries briefly;</p>
                                    <p>consoling not needed</p>
                                </td>
                                <td  data-cell="consolability_score_2-5" class="table-custom-width consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="consolability_score_3" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '3') selected-score @endif">
                                    <p>cries;</p>
                                    <p>becomes quiet when talked to</p>
                                </td>
                                <td  data-cell="consolability_score_3-5" class="table-custom-width consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '3.5') selected-score @endif"></td>
                                <td  data-cell="consolability_score_4" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '4') selected-score @endif">
                                    <p>cries;</p>
                                    <p>needs picking up to console</p>
                                </td>
                                <td  data-cell="consolability_score_4-5" class="table-custom-width consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="consolability_score_5" class="consolability_score_field @if(isset($hnne_details->consolability_score) && $hnne_details->consolability_score == '5') selected-score @endif">
                                    <p>cries cannot be consoled</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                            <tr>
                                <td colspan="9" class="{{ $hnne_details->consolability_status == 2 ? '' : 'hide' }} added-info">
                                    {!!$hnne_details->consolability_asymmetric !!}
                                </td>
                            </tr>
                            <tr class="cry">
                                <td class="row-head" rowspan="2">
                                    <strong>CRY</strong>
                                </td>
                                <td  data-cell="cry_score_1" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '1') selected-score @endif" align="center" valign="middle">
                                    <p>not cry at all</p>
                                </td>
                                <td  data-cell="cry_score_1-5" class="table-custom-width cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '1.5') selected-score @endif"></td>
                                <td  data-cell="cry_score_2" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '2') selected-score @endif">
                                    <p>whimpering cry only</p>
                                </td>
                                <td  data-cell="cry_score_2-5" class="table-custom-width cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '2.5') selected-score @endif"></td>
                                <td  data-cell="cry_score_3" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '3') selected-score @endif">
                                    <p>cries to stimuli but normal pitch</p>
                                </td>
                                <td  data-cell="cry_score_3-5" class="table-custom-width cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '3.5') selected-score @endif"></td>
                                <td >
                                </td>
                                <td  data-cell="cry_score_4-5" class="table-custom-width cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '4.5') selected-score @endif"></td>
                                <td  data-cell="cry_score_5" class="cry_score_field @if(isset($hnne_details->cry_score) && $hnne_details->cry_score == '5') selected-score @endif">
                                    <p>high pitched cry; often continuous</p>
                                </td>
                                <td class="no-border" rowspan="2">
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
                                <td colspan="9" class="{{ $hnne_details->cry_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hnne_details->cry_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="assessment-container col-md-12 assessment-page-break" id="hine-container">
                @include('registration.neuro.assessment_print_header')
                @php 
                    $hine_score = explode('-', $hine_details->total_hine_score);
                    $total_hine_score = $hine_score[0];
                    $hine_status = isset($hine_score[1]) ? $hine_score[1] : '';
                @endphp                
                @if ($hine_status == 'W')
                    @php $hine_status = 'Weak'; @endphp
                @else
                    @php $hine_status = 'Normal'; @endphp
                @endif

                <span id="assessment-score-2" class="hide">Score = {{ $total_hine_score }}</span>
                <span id="assessment-status-2" class="hide">Status: {{ $hine_status }}</span>
                <div id="hinescreening1">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <h4 class="m-0"><strong>ASSESSMENT OF CRANIAL NERVE FUNCTION <span class="pull-right">{{ $hine_details->assessment_of_cranial }} / {{ $overall_score->assessment_of_cranial }}</span></strong></h4>
                                </th>
                            </tr>
                            <tr>
                                <th class="unset-bg"></th>
                                <th class="unset-bg">Score 3</th>
                                <th class="unset-bg">2</th>
                                <th class="unset-bg">Score 1</th>
                                <th class="unset-bg">Score 0</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Facial appearance</strong>
                                    <p>(at rest and when crying or stimulated)</p>
                                </td>
                                <td data-cell="hine_facial_appearance_3" class="hine_facial_appearance_field @if(isset($hine_details->hine_facial_appearance) && $hine_details->hine_facial_appearance == '3') selected-score @endif">
                                    <p>Smiles or reacts to stimuli by closing eyes and grimacing</p>
                                </td>
                                <td data-cell="hine_facial_appearance_2" class="hine_facial_appearance_field @if(isset($hine_details->hine_facial_appearance) && $hine_details->hine_facial_appearance == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_facial_appearance_1" class="hine_facial_appearance_field @if(isset($hine_details->hine_facial_appearance) && $hine_details->hine_facial_appearance == '1') selected-score @endif">
                                    <p>Closes eyes but not tightly, poor facial expression</p>
                                </td>
                                <td data-cell="hine_facial_appearance_0" class="hine_facial_appearance_field @if(isset($hine_details->hine_facial_appearance) && $hine_details->hine_facial_appearance == '0') selected-score @endif">
                                    <p>Expressionless, does not react to stimuli</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_facial_appearance_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_facial_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Eye movements</strong>
                                </td>
                                <td data-cell="hine_eye_movements_3" class="hine_eye_movements_field @if(isset($hine_details->hine_eye_movements) && $hine_details->hine_eye_movements == '3') selected-score @endif">
                                    <p>Normal conjugate eye movements</p>
                                </td>
                                <td data-cell="hine_eye_movements_2" class="hine_eye_movements_field @if(isset($hine_details->hine_eye_movements) && $hine_details->hine_eye_movements == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_eye_movements_1" class="hine_eye_movements_field @if(isset($hine_details->hine_eye_movements) && $hine_details->hine_eye_movements == '1') selected-score @endif">
                                    <p><strong>Intermittent</strong> Deviation of eyes or abnormal movements</p>
                                </td>
                                <td data-cell="hine_eye_movements_0" class="hine_eye_movements_field @if(isset($hine_details->hine_eye_movements) && $hine_details->hine_eye_movements == '0') selected-score @endif">
                                    <p><strong>Continuous</strong> Deviation of eyes or abnormal movements</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_eye_movements_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_eye_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Visual response</strong>
                                    <p>Test ability to follow a black/white target</p>
                                </td>
                                <td data-cell="hine_visual_response_3" class="hine_visual_response_field @if(isset($hine_details->hine_visual_response) && $hine_details->hine_visual_response == '3') selected-score @endif">
                                    <p>Follows the target in a complete arc</p>
                                </td>
                                <td data-cell="hine_visual_response_2" class="hine_visual_response_field @if(isset($hine_details->hine_visual_response) && $hine_details->hine_visual_response == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_visual_response_1" class="hine_visual_response_field @if(isset($hine_details->hine_visual_response) && $hine_details->hine_visual_response == '1') selected-score @endif">
                                    <p>Follows target in an incomplete or asymmetrical arc</p>
                                </td>
                                <td data-cell="hine_visual_response_0" class="hine_visual_response_field @if(isset($hine_details->hine_visual_response) && $hine_details->hine_visual_response == '0') selected-score @endif">
                                    <p>Does not follow the target</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_visual_response_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_visual_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Auditory response</strong>
                                    <p>Test the response to a rattle</p>
                                </td>
                                <td data-cell="hine_auditory_response_3" class="hine_auditory_response_field @if(isset($hine_details->hine_auditory_response) && $hine_details->hine_auditory_response == '3') selected-score @endif">
                                    <p>Reacts to stimuli from both sides</p>
                                </td>
                                <td data-cell="hine_auditory_response_2" class="hine_auditory_response_field @if(isset($hine_details->hine_auditory_response) && $hine_details->hine_auditory_response == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_auditory_response_1" class="hine_auditory_response_field @if(isset($hine_details->hine_auditory_response) && $hine_details->hine_auditory_response == '1') selected-score @endif">
                                    <p>Doubtful reaction to stimuli or asymmetry of response</p>
                                </td>
                                <td data-cell="hine_auditory_response_0" class="hine_auditory_response_field @if(isset($hine_details->hine_auditory_response) && $hine_details->hine_auditory_response == '0') selected-score @endif">
                                    <p>No response</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_auditory_response_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_auditory_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Sucking/swallowing</strong>
                                    <p>Watch infant suck on breast or bottle. If older, ask about feeding, assoc. cough, excessive dribbling</p>
                                </td>
                                <td data-cell="hine_sucking_swallowing_3" class="hine_sucking_swallowing_field @if(isset($hine_details->hine_sucking_swallowing) && $hine_details->hine_sucking_swallowing == '3') selected-score @endif">
                                    <p>Good suck and swallowing</p>
                                </td>
                                <td data-cell="hine_sucking_swallowing_2" class="hine_sucking_swallowing_field @if(isset($hine_details->hine_sucking_swallowing) && $hine_details->hine_sucking_swallowing == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_sucking_swallowing_1" class="hine_sucking_swallowing_field @if(isset($hine_details->hine_sucking_swallowing) && $hine_details->hine_sucking_swallowing == '1') selected-score @endif">
                                    <p>Poor suck and/or swallow</p>
                                </td>
                                <td data-cell="hine_sucking_swallowing_0" class="hine_sucking_swallowing_field @if(isset($hine_details->hine_sucking_swallowing) && $hine_details->hine_sucking_swallowing == '0') selected-score @endif">
                                    <p>No sucking reflex, no swallowing</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_sucking_swallowing_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_sucking_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hinescreening2" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    <h4 class="m-0"><strong>ASSESSMENT OF POSTURE (note any asymmetries) <span class="pull-right">{{ $hine_details->assessment_of_posture }} / {{ $overall_score->assessment_of_posture }}</span></strong></h4>
                                </th>
                            </tr>
                            <tr>
                                <th class="unset-bg"></th>
                                <th class="unset-bg">Score 3</th>
                                <th class="unset-bg">2</th>
                                <th class="unset-bg">Score 1</th>
                                <th class="unset-bg">Score 0</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Head</strong>
                                    <p>(in sitting)</p>
                                </td>
                                <td data-cell="hine_head_3" class="hine_head_field text-center @if(isset($hine_details->hine_head) && $hine_details->hine_head == '3') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/head-1.svg" class="img" />
                                    <p>Straight; in midline</p>
                                </td>
                                <td data-cell="hine_head_2" class="hine_head_field text-center @if(isset($hine_details->hine_head) && $hine_details->hine_head == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_head_1" class="hine_head_field text-center @if(isset($hine_details->hine_head) && $hine_details->hine_head == '1') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/head-3.svg" class="img" />
                                    <p>Slightly to side or backward or forward</p>
                                </td>
                                <td data-cell="hine_head_0" class="hine_head_field text-center @if(isset($hine_details->hine_head) && $hine_details->hine_head == '0') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/head-4.svg" class="img" />
                                    <p>Markedly to side or backward or forward</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_head_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_head_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Trunk</strong>
                                    <p>(in sitting)</p>
                                </td>
                                <td data-cell="hine_trunk_3" class="hine_trunk_field text-center @if(isset($hine_details->hine_trunk) && $hine_details->hine_trunk == '3') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/trunk-1.svg" class="img" />
                                    <p>Straight</p>
                                </td>
                                <td data-cell="hine_trunk_2" class="hine_trunk_field text-center @if(isset($hine_details->hine_trunk) && $hine_details->hine_trunk == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_trunk_1" class="hine_trunk_field text-center @if(isset($hine_details->hine_trunk) && $hine_details->hine_trunk == '1') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/trunk-3.svg" class="img" />
                                    <p>Slightly curved or bent to side</p>
                                </td>
                                <td data-cell="hine_trunk_0" class="hine_trunk_field text-center @if(isset($hine_details->hine_trunk) && $hine_details->hine_trunk == '0') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/trunk-4.svg" class="img" />
                                    <br>
                                    <span>Very rounded</span> |
                                    <span>rocketing back</span> |
                                    <span>bent sideway</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_trunk_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_trunk_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Arms</strong>
                                    <p>(at rest)</p>
                                </td>
                                <td data-cell="hine_arms_3" class="hine_arms_field text-center @if(isset($hine_details->hine_arms) && $hine_details->hine_arms == '3') selected-score @endif">
                                    <p>In a neutral position, central straight or slightly bent</p>
                                </td>
                                <td data-cell="hine_arms_2" class="hine_arms_field text-center @if(isset($hine_details->hine_arms) && $hine_details->hine_arms == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_arms_1" class="hine_arms_field text-center @if(isset($hine_details->hine_arms) && $hine_details->hine_arms == '1') selected-score @endif">
                                    <p><strong>Slight</strong> internal rotation or external rotation</p>
                                    <p><strong>Intermittent</strong> dystonic posture</p>
                                </td>
                                <td data-cell="hine_arms_0" class="hine_arms_field text-center @if(isset($hine_details->hine_arms) && $hine_details->hine_arms == '0') selected-score @endif">
                                    <p><strong>Marked</strong> internal rotation or external rotation or</p>
                                    <p>dystonic posture, hemiplegic posture</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_arms_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_arms_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Hands</strong>
                                </td>
                                <td data-cell="hine_hands_3" class="hine_hands_field text-center @if(isset($hine_details->hine_hands) && $hine_details->hine_hands == '3') selected-score @endif">
                                    <p>Hands open</p>
                                </td>
                                <td data-cell="hine_hands_2" class="hine_hands_field text-center @if(isset($hine_details->hine_hands) && $hine_details->hine_hands == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_hands_1" class="hine_hands_field text-center @if(isset($hine_details->hine_hands) && $hine_details->hine_hands == '1') selected-score @endif">
                                    <p><strong>Intermittent</strong> adducted thumb or fisting</p>
                                </td>
                                <td data-cell="hine_hands_0" class="hine_hands_field text-center @if(isset($hine_details->hine_hands) && $hine_details->hine_hands == '0') selected-score @endif">
                                    <p><strong>Persistent</strong> adducted thumb or fisting</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_hands_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_hands_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Legs</strong>
                                    <p>in sitting</p>
                                    <br>
                                    <br>
                                    <br>
                                    <p>in supine and in standing</p>
                                </td>
                                <td data-cell="hine_legs_3" class="hine_legs_field text-center @if(isset($hine_details->hine_legs) && $hine_details->hine_legs == '3') selected-score @endif">
                                    <p>Able to sit with a straight back and legs straight or slightly bent (long sitting)</p>
                                    <img src="{{ url('/') }}/public/img/hine/legs-1.svg" class="img" />
                                    <p>Legs in neutral position straight or slightly bent</p>
                                </td>
                                <td data-cell="hine_legs_2" class="hine_legs_field text-center @if(isset($hine_details->hine_legs) && $hine_details->hine_legs == '2') selected-score @endif">
                                    <p><strong>Slight</strong> internal rotation or external rotation</p>
                                </td>
                                <td data-cell="hine_legs_1" class="hine_legs_field text-center @if(isset($hine_details->hine_legs) && $hine_details->hine_legs == '1') selected-score @endif">
                                    <p>Sit with straight back but knees bent at 15-20 °</p>
                                    <img src="{{ url('/') }}/public/img/hine/legs-3.svg" class="img" />
                                    <p>Internal rotation or external rotation at the hips</p>
                                </td>
                                <td data-cell="hine_legs_0" class="hine_legs_field text-center @if(isset($hine_details->hine_legs) && $hine_details->hine_legs == '0') selected-score @endif">
                                    <p>Unable to sit straight unless knees markedly bent (no long sitting)</p>
                                    <img src="{{ url('/') }}/public/img/hine/legs-4.svg" class="img" />
                                    <p><strong>Marked</strong> internal rotation or external rotation or fixed extension or flexion or contractures at hips and knees</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_legs_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_legs_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Feet</strong>
                                    <p>in supine and in standing</p>
                                </td>
                                <td data-cell="hine_feet_3" class="hine_feet_field text-center @if(isset($hine_details->hine_feet) && $hine_details->hine_feet == '3') selected-score @endif">
                                    <p>Central in neutral position</p>
                                    <br>
                                    <p>Toes straight midway between flexion and extension</p>
                                </td>
                                <td data-cell="hine_feet_2" class="hine_feet_field text-center @if(isset($hine_details->hine_feet) && $hine_details->hine_feet == '2') selected-score @endif"></td>
                                <td data-cell="hine_feet_1" class="hine_feet_field text-center @if(isset($hine_details->hine_feet) && $hine_details->hine_feet == '1') selected-score @endif">
                                    <p><strong>Slight</strong> internal rotation or external rotation</p>
                                    <p><strong>Intermittent</strong> Tendency to stand on tiptoes or toes up or curling under</p>
                                </td>
                                <td data-cell="hine_feet_0" class="hine_feet_field text-center @if(isset($hine_details->hine_feet) && $hine_details->hine_feet == '0') selected-score @endif">
                                    <p><strong>Marked</strong> internal rotation or external rotation at the ankle</p>
                                    <p><strong>Persistent</strong> Tendency to stand on tiptoes or toes up or curling under</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_feet_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_feet_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hinescreening3" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <h4 class="m-0"><strong>ASSESSMENT OF MOVEMENTS <span class="pull-right">{{ $hine_details->assessment_of_movements }} / {{ $overall_score->assessment_of_movements }}</span></strong></h4>
                                </th>
                            </tr>
                            <tr>
                                <th class="unset-bg"></th>
                                <th class="unset-bg">Score 3</th>
                                <th class="unset-bg">2</th>
                                <th class="unset-bg">Score 1</th>
                                <th class="unset-bg">Score 0</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Quantity</strong>
                                    <p>Watch infant lying in supine</p>
                                </td>
                                <td data-cell="hine_quantity_3" class="hine_quantity_field text-center @if(isset($hine_details->hine_quantity) && $hine_details->hine_quantity == '3') selected-score @endif">
                                    <p>Normal</p>
                                </td>
                                <td data-cell="hine_quantity_2" class="table-custom-width hine_quantity_field text-center @if(isset($hine_details->hine_quantity) && $hine_details->hine_quantity == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_quantity_1" class="hine_quantity_field text-center @if(isset($hine_details->hine_quantity) && $hine_details->hine_quantity == '1') selected-score @endif">
                                    <p>Excessive or sluggish</p>
                                </td>
                                <td data-cell="hine_quantity_0" class="hine_quantity_field text-center @if(isset($hine_details->hine_quantity) && $hine_details->hine_quantity == '0') selected-score @endif">
                                    <p>Minimal or none</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_quantity_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_quantity_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Quality</strong>
                                    <p>Observe infant’s spontaneous voluntary motor activity during the course of the assessment</p>
                                </td>
                                <td data-cell="hine_quality_3" class="hine_quality_field text-center @if(isset($hine_details->hine_quality) && $hine_details->hine_quality == '3') selected-score @endif">
                                    <p>Free, alternating, and smooth</p>
                                </td>
                                <td data-cell="hine_quality_2" class="table-custom-width hine_quality_field text-center @if(isset($hine_details->hine_quality) && $hine_details->hine_quality == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_quality_1" class="hine_quality_field text-center @if(isset($hine_details->hine_quality) && $hine_details->hine_quality == '1') selected-score @endif">
                                    <p>Jerky</p>
                                    <br>
                                    <p>Slight tremor</p>
                                </td>
                                <td data-cell="hine_quality_0" class="hine_quality_field text-center @if(isset($hine_details->hine_quality) && $hine_details->hine_quality == '0') selected-score @endif">
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
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_quality_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_quality_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hinescreening4" class="mt-15 assessment-page-break">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <h4 class="m-0"><strong>ASSESSMENT OF TONE <span class="pull-right">{{ $hine_details->assessment_of_tone }} / {{ $overall_score->assessment_of_tone }}</span></strong></h4>
                                </th>
                            </tr>
                            <tr>
                                <th class="unset-bg"></th>
                                <th class="unset-bg">Score 3</th>
                                <th class="unset-bg">2</th>
                                <th class="unset-bg">Score 1</th>
                                <th class="unset-bg">Score 0</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Scarf sign</strong>
                                    <p>Take the infant’s hand and pull the arm across the chest until there is resistance. Note the position of the elbow in relation to the midline.</p>
                                </td>
                                <td data-cell="hine_scraf_sign_3" class="hine_scraf_sign_field text-center @if(isset($hine_details->hine_scraf_sign) && $hine_details->hine_scraf_sign == '3') selected-score @endif">
                                    <p><strong>Range:</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/scarf-1.svg" class="img" />
                                </td>
                                <td data-cell="hine_scraf_sign_2" class="hine_scraf_sign_field text-center @if(isset($hine_details->hine_scraf_sign) && $hine_details->hine_scraf_sign == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_scraf_sign_1" class="hine_scraf_sign_field text-center @if(isset($hine_details->hine_scraf_sign) && $hine_details->hine_scraf_sign == '1') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/scarf-3.svg" class="img" />
                                </td>
                                <td data-cell="hine_scraf_sign_0" class="hine_scraf_sign_field text-center @if(isset($hine_details->hine_scraf_sign) && $hine_details->hine_scraf_sign == '0') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/scarf-4.svg" class="img" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_scraf_sign_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_scraf_sign_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Passive shoulder elevation</strong>
                                    <p>Lift arm up alongside infant’s head. Note resistance at shoulder and elbow.</p>
                                </td>
                                <td data-cell="hine_shoulder_elevation_3" class="hine_shoulder_elevation_field text-center @if(isset($hine_details->hine_shoulder_elevation) && $hine_details->hine_shoulder_elevation == '3') selected-score @endif">
                                    <p>Resistance overcomeable</p>
                                    <img src="{{ url('/') }}/public/img/hine/shoulder-elevation-1.svg" class="img" />
                                </td>
                                <td data-cell="hine_shoulder_elevation_2" class="hine_shoulder_elevation_field text-center @if(isset($hine_details->hine_shoulder_elevation) && $hine_details->hine_shoulder_elevation == '2') selected-score @endif">
                                    <p>Resistance difficult to overcome <br><br><span>R&ensp;&ensp;&ensp;&ensp;&ensp;L</span></p>
                                </td>
                                <td data-cell="hine_shoulder_elevation_1" class="hine_shoulder_elevation_field text-center @if(isset($hine_details->hine_shoulder_elevation) && $hine_details->hine_shoulder_elevation == '1') selected-score @endif">
                                    <p>No resistance</p>
                                    <img src="{{ url('/') }}/public/img/hine/shoulder-elevation-3.svg" class="img" />
                                </td>
                                <td data-cell="hine_shoulder_elevation_0" class="hine_shoulder_elevation_field text-center @if(isset($hine_details->hine_shoulder_elevation) && $hine_details->hine_shoulder_elevation == '0') selected-score @endif">
                                    <p>Resistance, not overcomeable</p>
                                    <img src="{{ url('/') }}/public/img/hine/shoulder-elevation-4.svg" class="img" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_shoulder_elevation_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_shoulder_elevation_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Pronation/supination</strong>
                                    <p>Steady the upper arm while pronating and supinating forearm, note resistance.</p>
                                </td>
                                <td data-cell="hine_pronation_supination_3" class="hine_pronation_supination_field text-center @if(isset($hine_details->hine_pronation_supination) && $hine_details->hine_pronation_supination == '3') selected-score @endif">
                                    <p>Full pronation and supination, no resistance</p>
                                </td>
                                <td data-cell="hine_pronation_supination_2" class="hine_pronation_supination_field text-center @if(isset($hine_details->hine_pronation_supination) && $hine_details->hine_pronation_supination == '2') selected-score @endif"></td>
                                <td data-cell="hine_pronation_supination_1" class="hine_pronation_supination_field text-center @if(isset($hine_details->hine_pronation_supination) && $hine_details->hine_pronation_supination == '1') selected-score @endif">
                                    <p>Resistance to full pronation / supination overcomeable</p>
                                </td>
                                <td data-cell="hine_pronation_supination_0" class="hine_pronation_supination_field text-center @if(isset($hine_details->hine_pronation_supination) && $hine_details->hine_pronation_supination == '0') selected-score @endif">
                                    <p>Full pronation and supination not possible, marked resistance</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_pronation_supination_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_pronation_supination_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Hip adductors</strong>
                                    <p>With both the infant’s legs extended, abduct them as far as possible. The angle formed by the legs is noted.</p>
                                </td>
                                <td data-cell="hine_hip_adductors_3" class="hine_hip_adductors_field text-center @if(isset($hine_details->hine_hip_adductors) && $hine_details->hine_hip_adductors == '3') selected-score @endif">
                                    <p><strong>Range: 150-80°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/hip-adductors-1.svg" class="img" />
                                </td>
                                <td data-cell="hine_hip_adductors_2" class="hine_hip_adductors_field text-center @if(isset($hine_details->hine_hip_adductors) && $hine_details->hine_hip_adductors == '2') selected-score @endif">
                                    <p><strong>150-160°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/hip-adductors-2.svg" class="img" />
                                </td>
                                <td data-cell="hine_hip_adductors_1" class="hine_hip_adductors_field text-center @if(isset($hine_details->hine_hip_adductors) && $hine_details->hine_hip_adductors == '1') selected-score @endif">
                                    <p><strong> >170°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/hip-adductors-3.svg" class="img" />
                                </td>
                                <td data-cell="hine_hip_adductors_0" class="hine_hip_adductors_field text-center @if(isset($hine_details->hine_hip_adductors) && $hine_details->hine_hip_adductors == '0') selected-score @endif">
                                    <p><strong> <80°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/hip-adductors-4.svg" class="img" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_hip_adductors_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_hip_adductors_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Popliteal angle</strong>
                                    <p>Keeping the infant’s bottom on the bed, flex both hips onto the abdomen, then extend the knees until there is resistance. Note the angle between upper and lower leg.</p>
                                </td>
                                <td data-cell="hine_popliteal_angle_3" class="hine_popliteal_angle_field text-center @if(isset($hine_details->hine_popliteal_angle) && $hine_details->hine_popliteal_angle == '3') selected-score @endif">
                                    <p><strong>Range: 150°-100°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/popliteal-angle-1.svg" class="img" />
                                </td>
                                <td data-cell="hine_popliteal_angle_2" class="hine_popliteal_angle_field text-center @if(isset($hine_details->hine_popliteal_angle) && $hine_details->hine_popliteal_angle == '2') selected-score @endif">
                                    <p><strong>150-160°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/popliteal-angle-2.svg" class="img" />
                                </td>
                                <td data-cell="hine_popliteal_angle_1" class="hine_popliteal_angle_field text-center @if(isset($hine_details->hine_popliteal_angle) && $hine_details->hine_popliteal_angle == '1') selected-score @endif">
                                    <p><strong> ~90° or > 170°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/popliteal-angle-3.svg" class="img" />
                                </td>
                                <td data-cell="hine_popliteal_angle_0" class="hine_popliteal_angle_field text-center @if(isset($hine_details->hine_popliteal_angle) && $hine_details->hine_popliteal_angle == '0') selected-score @endif">
                                    <p><strong> <80°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/popliteal-angle-4.svg" class="img" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_popliteal_angle_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_popliteal_angle_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Ankle dorsiflexion</strong>
                                    <p>With knee extended, dorsiflex the ankle. Note the angle between foot and leg.</p>
                                </td>
                                <td data-cell="hine_ankle_dorsiflexion_3" class="hine_ankle_dorsiflexion_field text-center @if(isset($hine_details->hine_ankle_dorsiflexion) && $hine_details->hine_ankle_dorsiflexion == '3') selected-score @endif">
                                    <p><strong>Range: 30°-85°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/ankle-1.svg" class="img" />
                                </td>
                                <td data-cell="hine_ankle_dorsiflexion_2" class="hine_ankle_dorsiflexion_field text-center @if(isset($hine_details->hine_ankle_dorsiflexion) && $hine_details->hine_ankle_dorsiflexion == '2') selected-score @endif">
                                    <p><strong>20-30°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/ankle-2.svg" class="img" />
                                </td>
                                <td data-cell="hine_ankle_dorsiflexion_1" class="hine_ankle_dorsiflexion_field text-center @if(isset($hine_details->hine_ankle_dorsiflexion) && $hine_details->hine_ankle_dorsiflexion == '1') selected-score @endif">
                                    <p><strong> <20°or 90°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/ankle-3.svg" class="img" />
                                </td>
                                <td data-cell="hine_ankle_dorsiflexion_0" class="hine_ankle_dorsiflexion_field text-center @if(isset($hine_details->hine_ankle_dorsiflexion) && $hine_details->hine_ankle_dorsiflexion == '0') selected-score @endif">
                                    <p><strong> > 90°</strong></p>
                                    <img src="{{ url('/') }}/public/img/hine/ankle-4.svg" class="img" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_ankle_dorsiflexion_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_ankle_dorsiflexion_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Pull to sit</strong>
                                    <p>Pull infant to sit by the wrists. (support head if necessary)</p>
                                </td>
                                <td data-cell="hine_pull_to_sit_3" class="hine_pull_to_sit_field text-center @if(isset($hine_details->hine_pull_to_sit) && $hine_details->hine_pull_to_sit == '3') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/pull-to-sit-1.svg" class="img" />
                                </td>
                                <td data-cell="hine_pull_to_sit_2" class="hine_pull_to_sit_field text-center @if(isset($hine_details->hine_pull_to_sit) && $hine_details->hine_pull_to_sit == '2') selected-score @endif"></td>
                                <td data-cell="hine_pull_to_sit_1" class="hine_pull_to_sit_field text-center @if(isset($hine_details->hine_pull_to_sit) && $hine_details->hine_pull_to_sit == '1') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/pull-to-sit-3.svg" class="img" />
                                </td>
                                <td data-cell="hine_pull_to_sit_0" class="hine_pull_to_sit_field text-center @if(isset($hine_details->hine_pull_to_sit) && $hine_details->hine_pull_to_sit == '0') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/pull-to-sit-4.svg" class="img" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_pull_to_sit_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_pull_to_sit_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Ventral suspension</strong>
                                    <p>Hold infant horizontally around trunk in ventral suspension; note position of back, limbs and head.</p>
                                </td>
                                <td data-cell="hine_ventral_suspension_3" class="hine_ventral_suspension_field text-center @if(isset($hine_details->hine_ventral_suspension) && $hine_details->hine_ventral_suspension == '3') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/ventral-suspension-1.svg" class="img" />
                                </td>
                                <td data-cell="hine_ventral_suspension_2" class="hine_ventral_suspension_field text-center @if(isset($hine_details->hine_ventral_suspension) && $hine_details->hine_ventral_suspension == '2') selected-score @endif"></td>
                                <td data-cell="hine_ventral_suspension_1" class="hine_ventral_suspension_field text-center @if(isset($hine_details->hine_ventral_suspension) && $hine_details->hine_ventral_suspension == '1') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/ventral-suspension-3.svg" class="img" />
                                </td>
                                <td data-cell="hine_ventral_suspension_0" class="hine_ventral_suspension_field text-center @if(isset($hine_details->hine_ventral_suspension) && $hine_details->hine_ventral_suspension == '0') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/ventral-suspension-4.svg" class="img" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_ventral_suspension_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_ventral_suspension_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hinescreening5" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <h4 class="m-0"><strong>REFLEXES AND REACTIONS <span class="pull-right">{{ $hine_details->reflexes_and_reactions }} / {{ $overall_score->reflexes_and_reactions }}</span></strong></h4>
                                </th>
                            </tr>
                            <tr>
                                <th class="unset-bg"></th>
                                <th class="unset-bg">Score 3</th>
                                <th class="unset-bg">2</th>
                                <th class="unset-bg">Score 1</th>
                                <th class="unset-bg">Score 0</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Arm protection</strong>
                                    <p>Pull the infant by one arm from the supine position (steady the contralateral hip) and note the reaction of arm on opposite side.</p>
                                </td>
                                <td data-cell="hine_arm_production_3" class="hine_arm_production_field text-center @if(isset($hine_details->hine_arm_production) && $hine_details->hine_arm_production == '3') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/arm-protection-1.svg" class="img" />
                                    <p>Arm & hand extend
                                        <br>
                                        <span>R &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;L</span>
                                    </p>
                                </td>
                                <td data-cell="hine_arm_production_2" class="hine_arm_production_field text-center @if(isset($hine_details->hine_arm_production) && $hine_details->hine_arm_production == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_arm_production_1" class="hine_arm_production_field text-center @if(isset($hine_details->hine_arm_production) && $hine_details->hine_arm_production == '1') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/arm-protection-3.svg" class="img" />
                                    <p>Arm semi-flexed
                                        <br>
                                        <span>R &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;L</span>
                                    </p>
                                </td>
                                <td data-cell="hine_arm_production_0" class="hine_arm_production_field text-center @if(isset($hine_details->hine_arm_production) && $hine_details->hine_arm_production == '0') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/arm-protection-4.svg" class="img" />
                                    <p>Arm fully flexed
                                        <br>
                                        <span>R &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;L</span>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_arm_production_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_arm_production_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Vertical suspension</strong>
                                    <p>hold infant under axilla making sure legs do not touch any surface – you may “tickle” feet to stimulate kicking.</p>
                                </td>
                                <td data-cell="hine_vertical_suspension_3" class="hine_vertical_suspension_field text-center @if(isset($hine_details->hine_vertical_suspension) && $hine_details->hine_vertical_suspension == '3') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/vertical-suspension-1.svg" class="img" />
                                    <p>Kicks symmetrically</p>
                                </td>
                                <td data-cell="hine_vertical_suspension_2" class="hine_vertical_suspension_field text-center @if(isset($hine_details->hine_vertical_suspension) && $hine_details->hine_vertical_suspension == '2') selected-score @endif">
                                </td>
                                <td data-cell="hine_vertical_suspension_1" class="hine_vertical_suspension_field text-center @if(isset($hine_details->hine_vertical_suspension) && $hine_details->hine_vertical_suspension == '1') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/vertical-suspension-3.svg" class="img" />
                                    <p>Kicks one leg more or poor kicking</p>
                                </td>
                                <td data-cell="hine_vertical_suspension_0" class="hine_vertical_suspension_field text-center @if(isset($hine_details->hine_vertical_suspension) && $hine_details->hine_vertical_suspension == '0') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/vertical-suspension-4.svg" class="img" />
                                    <p>No kicking even if stimulated or scissoring</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_vertical_suspension_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_vertical_suspension_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Lateral tilting</strong>
                                    <p>(describe side up). Hold infant up vertically near to hips and tilt sideways towards the horizontal. Note response of trunk, spine, limbs and head.</p>
                                </td>
                                <td data-cell="hine_lateral_tilting_3" class="hine_lateral_tilting_field text-center @if(isset($hine_details->hine_lateral_tilting) && $hine_details->hine_lateral_tilting == '3') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/lateral-tilting-1.svg" class="img" />
                                </td>
                                <td data-cell="hine_lateral_tilting_2" class="hine_lateral_tilting_field text-center @if(isset($hine_details->hine_lateral_tilting) && $hine_details->hine_lateral_tilting == '2') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/lateral-tilting-2.svg" class="img" />
                                </td>
                                <td data-cell="hine_lateral_tilting_1" class="hine_lateral_tilting_field text-center @if(isset($hine_details->hine_lateral_tilting) && $hine_details->hine_lateral_tilting == '1') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/lateral-tilting-3.svg" class="img" />
                                </td>
                                <td data-cell="hine_lateral_tilting_0" class="hine_lateral_tilting_field text-center @if(isset($hine_details->hine_lateral_tilting) && $hine_details->hine_lateral_tilting == '0') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/lateral-tilting-4.svg" class="img" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_lateral_tilting_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_lateral_tilting_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Forward parachute</strong>
                                    <p>Hold infant up vertically and quickly tilt forwards. Note reaction /symmetry of arm responses,</p>
                                </td>
                                <td data-cell="hine_forward_parachute_3" class="hine_forward_parachute_field text-center @if(isset($hine_details->hine_forward_parachute) && $hine_details->hine_forward_parachute == '3') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/forward-parachute-1.svg" class="img" />
                                    <p>(after 6 months)</p>
                                </td>
                                <td data-cell="hine_forward_parachute_2" class="hine_forward_parachute_field text-center @if(isset($hine_details->hine_forward_parachute) && $hine_details->hine_forward_parachute == '2') selected-score @endif"></td>
                                <td data-cell="hine_forward_parachute_1" class="hine_forward_parachute_field text-center @if(isset($hine_details->hine_forward_parachute) && $hine_details->hine_forward_parachute == '1') selected-score @endif">
                                    <img src="{{ url('/') }}/public/img/hine/forward-parachute-3.svg" class="img" />
                                    <p>(after 6 months)</p>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_forward_parachute_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_forward_parachute_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Tendon Reflexes</strong>
                                    <p>Have child relaxed, sitting or lying – use small hammer</p>
                                </td>
                                <td data-cell="hine_tendon_reflexes_3" class="hine_tendon_reflexes_field text-center @if(isset($hine_details->hine_tendon_reflexes) && $hine_details->hine_tendon_reflexes == '3') selected-score @endif">
                                    <p>Easily elicitable biceps knee ankle</p>
                                </td>
                                <td data-cell="hine_tendon_reflexes_2" class="hine_tendon_reflexes_field text-center @if(isset($hine_details->hine_tendon_reflexes) && $hine_details->hine_tendon_reflexes == '2') selected-score @endif">
                                    <p>Mildly brisk bicep knee ankle</p>
                                </td>
                                <td data-cell="hine_tendon_reflexes_1" class="hine_tendon_reflexes_field text-center @if(isset($hine_details->hine_tendon_reflexes) && $hine_details->hine_tendon_reflexes == '1') selected-score @endif">
                                    <p>Brisk biceps knee ankle</p>
                                </td>
                                <td data-cell="hine_tendon_reflexes_0" class="hine_tendon_reflexes_field text-center @if(isset($hine_details->hine_tendon_reflexes) && $hine_details->hine_tendon_reflexes == '0') selected-score @endif">
                                    <p>Clonus or absent biceps knee ankle</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="{{ $hine_details->hine_tendon_reflexes_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_tendon_reflexes_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hinescreening6" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6">
                                    <h4 class="m-0"><strong>SECTION 2 MOTOR MILESTONES (not scored; note asymmetries)</strong></h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Head control</strong>
                                </td>
                                <td data-cell="hine_head_control_5" class="hine_head_control_field text-center @if(isset($hine_details->hine_head_control) && $hine_details->hine_head_control == '5') selected-score @endif">
                                    <p>Unable to maintain head upright <br> normal to 3m</p>
                                </td>
                                <td data-cell="hine_head_control_4" class="hine_head_control_field text-center @if(isset($hine_details->hine_head_control) && $hine_details->hine_head_control == '4') selected-score @endif">
                                    <p>Wobbles <br> normal up to 3m</p>
                                </td>
                                <td data-cell="hine_head_control_3" class="hine_head_control_field text-center @if(isset($hine_details->hine_head_control) && $hine_details->hine_head_control == '3') selected-score @endif">
                                    <p>Maintained upright all the time <br> normal from 5m</p>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="{{ $hine_details->hine_head_control_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_head_control_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Sitting</strong>
                                </td>
                                <td data-cell="hine_sitting_5" class="hine_sitting_field text-center @if(isset($hine_details->hine_sitting) && $hine_details->hine_sitting == '5') selected-score @endif">
                                    <p>Cannot sit</p>
                                </td>
                                <td data-cell="hine_sitting_4" class="hine_sitting_field text-center @if(isset($hine_details->hine_sitting) && $hine_details->hine_sitting == '4') selected-score @endif">
                                    <p>With support at hips</p>
                                    <img src="{{ url('/') }}/public/img/hine/sitting-2.svg" class="img" />
                                    <p>normal at 4m</p>
                                </td>
                                <td data-cell="hine_sitting_3" class="hine_sitting_field text-center @if(isset($hine_details->hine_sitting) && $hine_details->hine_sitting == '3') selected-score @endif">
                                    <p>Props</p>
                                    <img src="{{ url('/') }}/public/img/hine/sitting-3.svg" class="img" />
                                    <p>normal at 6m</p>
                                </td>
                                <td data-cell="hine_sitting_2" class="hine_sitting_field text-center @if(isset($hine_details->hine_sitting) && $hine_details->hine_sitting == '2') selected-score @endif">
                                    <p>Stable sit</p>
                                    <img src="{{ url('/') }}/public/img/hine/sitting-4.svg" class="img" />
                                    <p>normal at 7-8m</p>
                                </td>
                                <td data-cell="hine_sitting_1" class="hine_sitting_field text-center @if(isset($hine_details->hine_sitting) && $hine_details->hine_sitting == '1') selected-score @endif">
                                    <p>Pivots (rotates)</p>
                                    <img src="{{ url('/') }}/public/img/hine/sitting-5.svg" class="img" />
                                    <p>normal at 9m</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="{{ $hine_details->hine_sitting_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_sitting_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Voluntary grasp – note side</strong>
                                </td>
                                <td data-cell="hine_voluntary_grasp_5" class="hine_voluntary_grasp_field text-center @if(isset($hine_details->hine_voluntary_grasp) && $hine_details->hine_voluntary_grasp == '5') selected-score @endif">
                                    <p>No grasp</p>
                                </td>
                                <td data-cell="hine_voluntary_grasp_4" class="hine_voluntary_grasp_field text-center @if(isset($hine_details->hine_voluntary_grasp) && $hine_details->hine_voluntary_grasp == '4') selected-score @endif">
                                    <p>Uses whole hand</p>
                                </td>
                                <td data-cell="hine_voluntary_grasp_3" class="hine_voluntary_grasp_field text-center @if(isset($hine_details->hine_voluntary_grasp) && $hine_details->hine_voluntary_grasp == '3') selected-score @endif">
                                    <p>Index finger and thumb but immature grasp</p>
                                </td>
                                <td data-cell="hine_voluntary_grasp_2" class="hine_voluntary_grasp_field text-center @if(isset($hine_details->hine_voluntary_grasp) && $hine_details->hine_voluntary_grasp == '2') selected-score @endif">
                                    <p>Pincer grasp</p>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="{{ $hine_details->hine_voluntary_grasp_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_voluntary_grasp_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Ability to kick in supine</strong>
                                </td>
                                <td data-cell="hine_ability_to_kick_5" class="hine_ability_to_kick_field text-center @if(isset($hine_details->hine_ability_to_kick) && $hine_details->hine_ability_to_kick == '5') selected-score @endif">
                                    <p>No kicking</p>
                                </td>
                                <td data-cell="hine_ability_to_kick_4" class="hine_ability_to_kick_field text-center @if(isset($hine_details->hine_ability_to_kick) && $hine_details->hine_ability_to_kick == '4') selected-score @endif">
                                    <p>Kicks horizontally but legs do not lift</p>
                                </td>
                                <td data-cell="hine_ability_to_kick_3" class="hine_ability_to_kick_field text-center @if(isset($hine_details->hine_ability_to_kick) && $hine_details->hine_ability_to_kick == '3') selected-score @endif">
                                    <p>Upward (vertically)</p>
                                    <img src="{{ url('/') }}/public/img/hine/kick-3.svg" class="img" />
                                    <p>normal at 3m</p>
                                </td>
                                <td data-cell="hine_ability_to_kick_2" class="hine_ability_to_kick_field text-center @if(isset($hine_details->hine_ability_to_kick) && $hine_details->hine_ability_to_kick == '2') selected-score @endif">
                                    <p>Touches leg</p>
                                    <img src="{{ url('/') }}/public/img/hine/kick-4.svg" class="img" />
                                    <p>normal at 4-5m</p>
                                </td>
                                <td data-cell="hine_ability_to_kick_1" class="hine_ability_to_kick_field text-center @if(isset($hine_details->hine_ability_to_kick) && $hine_details->hine_ability_to_kick == '1') selected-score @endif">
                                    <p>Touches toes</p>
                                    <img src="{{ url('/') }}/public/img/hine/kick-5.svg" class="img" />
                                    <p>normal at 5-6m</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="{{ $hine_details->hine_ability_to_kick_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_ability_to_kick_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Rolling - note through which side(s)</strong>
                                </td>
                                <td data-cell="hine_rolling_5" class="hine_rolling_field text-center @if(isset($hine_details->hine_rolling) && $hine_details->hine_rolling == '5') selected-score @endif">
                                    <p>No rolling</p>
                                </td>
                                <td data-cell="hine_rolling_4" class="hine_rolling_field text-center @if(isset($hine_details->hine_rolling) && $hine_details->hine_rolling == '4') selected-score @endif">
                                    <p>Rolling to side</p>
                                    <p>normal at 4m</p>
                                </td>
                                <td data-cell="hine_rolling_3" class="hine_rolling_field text-center @if(isset($hine_details->hine_rolling) && $hine_details->hine_rolling == '3') selected-score @endif">
                                    <p>Prone to supine</p>
                                    <p>normal at 3m</p>
                                </td>
                                <td data-cell="hine_rolling_2" class="hine_rolling_field text-center @if(isset($hine_details->hine_rolling) && $hine_details->hine_rolling == '2') selected-score @endif">
                                    <p>Supine to prone</p>
                                    <p>normal at 6m</p>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="{{ $hine_details->hine_rolling_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_rolling_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Crawling</strong>
                                </td>
                                <td data-cell="hine_crawling_5" class="hine_crawling_field text-center @if(isset($hine_details->hine_crawling) && $hine_details->hine_crawling == '5') selected-score @endif">
                                    <p>No rolling</p>
                                </td>
                                <td data-cell="hine_crawling_4" class="hine_crawling_field text-center @if(isset($hine_details->hine_crawling) && $hine_details->hine_crawling == '4') selected-score @endif">
                                    <p>On elbows</p>
                                    <img src="{{ url('/') }}/public/img/hine/crawling-4.svg" class="img" />
                                    <p>normal at 3m</p>
                                </td>
                                <td data-cell="hine_crawling_3" class="hine_crawling_field text-center @if(isset($hine_details->hine_crawling) && $hine_details->hine_crawling == '3') selected-score @endif">
                                    <p>On outstretched hands</p>
                                    <img src="{{ url('/') }}/public/img/hine/crawling-4.svg" class="img" />
                                    <p>normal at 4m</p>
                                </td>
                                <td data-cell="hine_crawling_2" class="hine_crawling_field text-center @if(isset($hine_details->hine_crawling) && $hine_details->hine_crawling == '2') selected-score @endif">
                                    <p>Crawling flat on abdomen</p>
                                    <img src="{{ url('/') }}/public/img/hine/crawling-4.svg" class="img" />
                                    <p>normal at 8m</p>
                                </td>
                                <td data-cell="hine_crawling_1" class="hine_crawling_field text-center @if(isset($hine_details->hine_crawling) && $hine_details->hine_crawling == '1') selected-score @endif">
                                    <p>Crawling on hands and knees</p>
                                    <img src="{{ url('/') }}/public/img/hine/crawling-4.svg" class="img" />
                                    <p>normal at 10m</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="{{ $hine_details->hine_crawling_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_crawling_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Standing</strong>
                                </td>
                                <td data-cell="hine_standing_5" class="hine_standing_field text-center @if(isset($hine_details->hine_standing) && $hine_details->hine_standing == '5') selected-score @endif">
                                    <p>Does not support weight</p>
                                </td>
                                <td data-cell="hine_standing_4" class="hine_standing_field text-center @if(isset($hine_details->hine_standing) && $hine_details->hine_standing == '4') selected-score @endif">
                                    <p>Supports weight</p>
                                    <p>normal at 4m</p>
                                </td>
                                <td data-cell="hine_standing_3" class="hine_standing_field text-center @if(isset($hine_details->hine_standing) && $hine_details->hine_standing == '3') selected-score @endif">
                                    <p>Stands with support</p>
                                    <p>normal at 7m</p>
                                </td>
                                <td data-cell="hine_standing_2" class="hine_standing_field text-center @if(isset($hine_details->hine_standing) && $hine_details->hine_standing == '2') selected-score @endif">
                                    <p>Stands unaided</p>
                                    <p>normal at 12m</p>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="{{ $hine_details->hine_standing_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_standing_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Walking</strong>
                                </td>
                                <td></td>
                                <td data-cell="hine_walking_4" class="hine_walking_field text-center @if(isset($hine_details->hine_walking) && $hine_details->hine_walking == '4') selected-score @endif">
                                    <p>Bouncing</p>
                                    <p>normal at 6m</p>
                                </td>
                                <td data-cell="hine_walking_3" class="hine_walking_field text-center @if(isset($hine_details->hine_walking) && $hine_details->hine_walking == '3') selected-score @endif">
                                    <p>Cruising (walks holding on)</p>
                                    <p>normal at 12m</p>
                                </td>
                                <td data-cell="hine_walking_2" class="hine_walking_field text-center @if(isset($hine_details->hine_walking) && $hine_details->hine_walking == '2') selected-score @endif">
                                    <p>Walking independently</p>
                                    <p>normal at 15m</p>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="{{ $hine_details->hine_walking_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_walking_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="hinescreening7" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="7">
                                    <h4 class="m-0"><strong>BEHAVIOUR (not scored)</strong></h4>
                                </th>
                            </tr>
                            <tr>
                                <th class="unset-bg"></th>
                                <th class="unset-bg">1</th>
                                <th class="unset-bg">2</th>
                                <th class="unset-bg">3</th>
                                <th class="unset-bg">4</th>
                                <th class="unset-bg">5</th>
                                <th class="unset-bg">6</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Conscious state</strong>
                                </td>
                                <td data-cell="hine_conscious_state_5" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '5') selected-score @endif">
                                    <p>Unrousable</p>
                                </td>
                                <td data-cell="hine_conscious_state_4" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '4') selected-score @endif">
                                    <p>Drowsy</p>
                                </td>
                                <td data-cell="hine_conscious_state_3" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '3') selected-score @endif">
                                    <p>Sleep but wakes easily</p>
                                </td>
                                <td data-cell="hine_conscious_state_2" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '2') selected-score @endif">
                                    <p>Awake but no interest</p>
                                </td>
                                <td data-cell="hine_conscious_state_1" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '1') selected-score @endif">
                                    <p>Loses interest</p>
                                </td>
                                <td data-cell="hine_conscious_state_0" class="hine_conscious_state_field text-center @if(isset($hine_details->hine_conscious_state) && $hine_details->hine_conscious_state == '0') selected-score @endif">
                                    <p>Maintains interest</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="{{  $hine_details->hine_conscious_state_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_conscious_state_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Emotional state</strong>
                                </td>
                                <td data-cell="hine_emotional_state_5" class="hine_emotional_state_field text-center @if(isset($hine_details->hine_emotional_state) && $hine_details->hine_emotional_state == '5') selected-score @endif">
                                    <p>Irritable, not consolable</p>
                                </td>
                                <td data-cell="hine_emotional_state_4" class="hine_emotional_state_field text-center @if(isset($hine_details->hine_emotional_state) && $hine_details->hine_emotional_state == '4') selected-score @endif">
                                    <p>Irritable, carer can console</p>
                                </td>
                                <td data-cell="hine_emotional_state_3" class="hine_emotional_state_field text-center @if(isset($hine_details->hine_emotional_state) && $hine_details->hine_emotional_state == '3') selected-score @endif">
                                    <p>Irritable when approached</p>
                                </td>
                                <td data-cell="hine_emotional_state_2" class="hine_emotional_state_field text-center @if(isset($hine_details->hine_emotional_state) && $hine_details->hine_emotional_state == '2') selected-score @endif">
                                    <p>Neither happy or unhappy</p>
                                </td>
                                <td data-cell="hine_emotional_state_1" class="hine_emotional_state_field text-center @if(isset($hine_details->hine_emotional_state) && $hine_details->hine_emotional_state == '1') selected-score @endif">
                                    <p>Happy and smiling</p>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="{{ $hine_details->hine_emotional_state_status == 2 ? '' : 'hide' }} added-info">                                
                                    {!! $hine_details->hine_emotional_state_asymmetric !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="row-head" rowspan="2">
                                    <strong>Social orientation</strong>
                                </td>
                                <td data-cell="hine_social_orientation_5" class="hine_social_orientation_field text-center @if(isset($hine_details->hine_social_orientation) && $hine_details->hine_social_orientation == '5') selected-score @endif">
                                    <p>Avoiding, withdrawn</p>
                                </td>
                                <td data-cell="hine_social_orientation_4" class="hine_social_orientation_field text-center @if(isset($hine_details->hine_social_orientation) && $hine_details->hine_social_orientation == '4') selected-score @endif">
                                    <p>Hesitant</p>
                                </td>
                                <td data-cell="hine_social_orientation_3" class="hine_social_orientation_field text-center @if(isset($hine_details->hine_social_orientation) && $hine_details->hine_social_orientation == '3') selected-score @endif">
                                    <p>Accepts approach</p>
                                </td>
                                <td data-cell="hine_social_orientation_2" class="hine_social_orientation_field text-center @if(isset($hine_details->hine_social_orientation) && $hine_details->hine_social_orientation == '2') selected-score @endif">
                                    <p>Friendly</p>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="{{ $hine_details->hine_social_orientation_status == 2 ? '' : 'hide' }} added-info">
                                    {!! $hine_details->hine_social_orientation_asymmetric !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="assessment-container col-md-12 assessment-page-break" id="m-chat-container">
                @include('registration.neuro.assessment_print_header')
                @php $r_status = 'Normal'; @endphp
                @php $f_status = ''; @endphp
                @if ($m_chat_score < 3)
                    @php $r_status = 'Low Risk'; @endphp
                @elseif ($m_chat_score >= 3 && $m_chat_score <= 7)
                    @php $r_status = 'Medium Risk'; @endphp
                    @if ($m_chat_f_score > 1)
                        @php $f_status = 'Higher Risk'; @endphp
                    @else
                        @php $f_status = 'Normal'; @endphp
                    @endif
                @else
                    @php $r_status = 'High Risk'; @endphp
                @endif

                <span id="assessment-status-3" class="hide"></span>
                <div id="m-chat-container">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <h4 class="m-0">
                                        <strong>M-CHAT-R <sup>TM</sup></strong>
                                        <span class="pull-right">
                                            <h3 class="mt-0">Status:  {{ $r_status }}</h3> 
                                            <span class="pull-right"><b>Score = {{ $m_chat_score }}</b></span>
                                        </span>                                        
                                    </h4>
                                </th>
                            </tr>
                            <tr>
                                <th><b>No.</b></th>
                                <th><b>Question</b></th>
                                <th><b>Answer</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($m_chat_questions as $key => $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td class="text-left">{{ $value->question }}</td>
                                <td>{{ isset($m_chat_results[$value->id]) ? $m_chat_results[$value->id] : '' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (isset($m_chat_f_score) && !is_null($m_chat_f_score) && $m_chat_score >= 3 && $m_chat_score <= 7)
                <div id="m-chat-followup-container" class="assessment-page-break">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    <h4 class="m-0">
                                        <strong>M-CHAT-FOLLOWUP <sup>TM</sup> </strong>
                                        <span class="pull-right">
                                            <h3 class="mt-0">Status: {{ $f_status }}</h3>
                                            <span class="pull-right"><b>Score = {{ $m_chat_f_score }}</b></span>
                                        </span>                                        
                                    </h4>
                                </th>
                            </tr>
                            <tr>
                                <th><b>No.</b></th>
                                <th><b>Question</b></th>
                                <th><b>Answer</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($m_chat_followup_questions as $key => $value)
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td class="text-left">{{ $value->question }}</td>
                                <td>{{ isset($m_chat_followup_results[$value->id]) ? $m_chat_followup_results[$value->id] : '' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <div class="assessment-container col-md-12 assessment-page-break" id="dasii-container">
                @include('registration.neuro.assessment_print_header')
                <span id="assessment-status-4" class="hide"></span>
                @php $mental_status = '> Average'; @endphp
                @if ($results->mental_development_quotient < 70)
                    @php $mental_status = 'Delay'; @endphp
                @elseif ($results->mental_development_quotient >= 70 && $results->mental_development_quotient < 85)
                    @php $mental_status = '< Average'; @endphp
                @elseif ($results->mental_development_quotient >= 85 && $results->mental_development_quotient < 115)
                    @php $mental_status = 'Average'; @endphp
                @endif
                @php $motor_status = '> Average'; @endphp
                @if ($results->motor_development_quotient < 70)
                    @php $motor_status = 'Delay'; @endphp
                @elseif ($results->motor_development_quotient >= 70 && $results->motor_development_quotient < 85)
                    @php $motor_status = '< Average'; @endphp
                @elseif ($results->motor_development_quotient >= 85 && $results->motor_development_quotient < 115)
                    @php $motor_status = 'Average'; @endphp
                @endif
                <div id="mental-container">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="7">
                                    <h4 class="m-0">
                                        <strong>Mental Scales</strong>
                                        <span class="pull-right">
                                            <h3 class="mt-0">Status: {{ $mental_status }}</h3>
                                            <span class="pull-right"><b>Age = {{ $results->mental_development_age }}; Quotient = {{ $results->mental_development_quotient }}</b></span>
                                        </span>                                        
                                    </h4>
                                </th>
                            </tr>
                            <tr>
                                <th class="vertical-align-middle input-width-mini" rowspan="2"><b>No.</b></th>
                                <th class="vertical-align-middle" rowspan="2"><b>Question</b></th>
                                <th class="vertical-align-middle input-width-mini" rowspan="2"><b>Answer</b></th>
                                <th class="vertical-align-middle" colspan="3"><b>Age placement</b></th>
                                <th class="vertical-align-middle input-width-mini" rowspan="2"><b>Content cluster</b></th>
                            </tr>
                            <tr>
                                <th class="vertical-align-middle input-width-mini"><b>50%</b></th>
                                <th class="vertical-align-middle input-width-mini"><b>3%</b></th>
                                <th class="vertical-align-middle input-width-mini"><b>97%</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dasii_mental_questions as $key => $value)
                            <tr class="{{ $value->question_number == $results->mental_prior_pass ? 'prior-pass' : ($value->question_number == $results->mental_rest_fail ? 'rest-fail' : '') }}" >
                                <td>{{ $value->question_number }}</td>
                                <td class="text-left">{{ $value->question }}</td>
                                <td>{{ @$mental_answer[$value->question_number] }}</td>
                                <td>{{ $value->fiftieth_percentile }}</td>
                                <td>{{ $value->third_percentile }}</td>
                                <td>{{ $value->ninety_seventh_percentile }}</td>
                                <td>{{ $value->content_cluster }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="motor-container" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="7">
                                    <h4 class="m-0">
                                        <strong>Motor Scales</strong>
                                        <span class="pull-right">
                                            <h3 class="mt-0">Status: {{ $motor_status }}</h3>
                                            <span class="pull-right"><b>Age = {{ $results->motor_development_age }}; Quotient = {{ $results->motor_development_quotient }}</b></span>
                                        </span>                                        
                                    </h4>
                                </th>
                            </tr>
                            <tr>
                                <th class="vertical-align-middle input-width-mini" rowspan="2"><b>No.</b></th>
                                <th class="vertical-align-middle" rowspan="2"><b>Question</b></th>
                                <th class="vertical-align-middle input-width-mini" rowspan="2"><b>Answer</b></th>
                                <th class="vertical-align-middle" colspan="3"><b>Age placement</b></th>
                                <th class="vertical-align-middle input-width-mini" rowspan="2"><b>Content cluster</b></th>
                            </tr>
                            <tr>
                                <th class="vertical-align-middle input-width-mini"><b>50%</b></th>
                                <th class="vertical-align-middle input-width-mini"><b>3%</b></th>
                                <th class="vertical-align-middle input-width-mini"><b>97%</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dasii_motor_questions as $key => $value)
                            <tr class="{{ $value->question_number == $results->motor_prior_pass ? 'prior-pass' : ($value->question_number == $results->motor_rest_fail ? 'rest-fail' : '') }}" >
                                <td>{{ $value->question_number }}</td>
                                <td class="text-left">{{ $value->question }}</td>
                                <td>{{ @$motor_answer[$value->question_number] }}</td>
                                <td>{{ $value->fiftieth_percentile }}</td>
                                <td>{{ $value->third_percentile }}</td>
                                <td>{{ $value->ninety_seventh_percentile }}</td>
                                <td>{{ $value->content_cluster }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="cluster-container" class="mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <h4 class="m-0"><b>Cluster</b><span class="pull-right"><b>Range: {{ $results->cluster_range }}</b></span></h4>
                                </th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th class="input-width-mini"><b>Cluster No.</b></th>
                                <th class="vertical-align-middle"><b>Mental clusters and no. of items</b></th>
                                <th class="input-width-mini"><b>Items Passed</b></th>
                                <th class="input-width-mini vertical-align-middle"><b>PR</b></th>
                                <th class="input-width-medium vertical-align-middle"><b>Remarks</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>I</td>
                                <td>Cognizance - Visual (25)</td>
                                <td>{{ $results->mental_cluster_1 }}</td>
                                <td>{!! $results->mental_cluster_pr_1 !!}</td>
                                <td>{{ $results->mental_cluster_remarks_1 }}</td>
                            </tr>
                            <tr>
                                <td>II</td>
                                <td>Cognizance - Auditory (7)</td>
                                <td>{{ $results->mental_cluster_2 }}</td>
                                <td>{!! $results->mental_cluster_pr_2 !!}</td>
                                <td>{{ $results->mental_cluster_remarks_2 }}</td>
                            </tr>
                            <tr>
                                <td>III</td>
                                <td>Reaching, manipulating and exploring (36)</td>
                                <td>{{ $results->mental_cluster_3 }}</td>
                                <td>{!! $results->mental_cluster_pr_3 !!}</td>
                                <td>{{ $results->mental_cluster_remarks_3 }}</td>
                            </tr>
                            <tr>
                                <td>IV</td>
                                <td>Memory (11)</td>
                                <td>{{ $results->mental_cluster_4 }}</td>
                                <td>{!! $results->mental_cluster_pr_4 !!}</td>
                                <td>{{ $results->mental_cluster_remarks_4 }}</td>
                            </tr>
                            <tr>
                                <td>V</td>
                                <td>Social interaction and imitalive behaviour (22)</td>
                                <td>{{ $results->mental_cluster_5 }}</td>
                                <td>{!! $results->mental_cluster_pr_5 !!}</td>
                                <td>{{ $results->mental_cluster_remarks_5 }}</td>
                            </tr>
                            <tr>
                                <td>VI</td>
                                <td>Language - Vocalisation, speech and communication (11)</td>
                                <td>{{ $results->mental_cluster_6 }}</td>
                                <td>{!! $results->mental_cluster_pr_6 !!}</td>
                                <td>{{ $results->mental_cluster_remarks_6 }}</td>
                            </tr>
                            <tr>
                                <td>VII</td>
                                <td>Language - Vocabulary and comprehension (18)</td>
                                <td>{{ $results->mental_cluster_7 }}</td>
                                <td>{!! $results->mental_cluster_pr_7 !!}</td>
                                <td>{{ $results->mental_cluster_remarks_7 }}</td>
                            </tr>
                            <tr>
                                <td>VIII</td>
                                <td>Understanding relationship (18)</td>
                                <td>{{ $results->mental_cluster_8 }}</td>
                                <td>{!! $results->mental_cluster_pr_8 !!}</td>
                                <td>{{ $results->mental_cluster_remarks_8 }}</td>
                            </tr>
                            <tr>
                                <td>IX</td>
                                <td>Differentiation by use, shapes and movements (8)</td>
                                <td>{{ $results->mental_cluster_9 }}</td>
                                <td>{!! $results->mental_cluster_pr_9 !!}</td>
                                <td>{{ $results->mental_cluster_remarks_9 }}</td>
                            </tr>
                            <tr>
                                <td>X</td>
                                <td>Manual dexterity (7)</td>
                                <td>{{ $results->mental_cluster_10 }}</td>
                                <td>{!! $results->mental_cluster_pr_10 !!}</td>
                                <td>{{ $results->mental_cluster_remarks_10 }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered mt-15">
                        <thead>
                            <tr>
                                <th class="input-width-mini"><b>Cluster No.</b></th>
                                <th class="vertical-align-middle"><b>Motor clusters and no. of items</b></th>
                                <th class="input-width-mini"><b>Items Passed</b></th>
                                <th class="input-width-mini vertical-align-middle"><b>PR</b></th>
                                <th class="input-width-medium vertical-align-middle"><b>Remarks</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>I</td>
                                <td>Neck control (7)</td>
                                <td>{{ $results->motor_cluster_1 }}</td>
                                <td>{!! $results->motor_cluster_pr_1 !!}</td>
                                <td>{{ $results->motor_cluster_remarks_1 }}</td>
                            </tr>
                            <tr>
                                <td>II</td>
                                <td>Body control (23)</td>
                                <td>{{ $results->motor_cluster_2 }}</td>
                                <td>{!! $results->motor_cluster_pr_2 !!}</td>
                                <td>{{ $results->motor_cluster_remarks_2 }}</td>
                            </tr>
                            <tr>
                                <td>III</td>
                                <td>Locomotion - I (10)</td>
                                <td>{{ $results->motor_cluster_3 }}</td>
                                <td>{!! $results->motor_cluster_pr_3 !!}</td>
                                <td>{{ $results->motor_cluster_remarks_3 }}</td>
                            </tr>
                            <tr>
                                <td>IV</td>
                                <td>Locomotion - II (13)</td>
                                <td>{{ $results->motor_cluster_4 }}</td>
                                <td>{!! $results->motor_cluster_pr_4 !!}</td>
                                <td>{{ $results->motor_cluster_remarks_4 }}</td>
                            </tr>
                            <tr>
                                <td>V</td>
                                <td>Manipulation (14)</td>
                                <td>{{ $results->motor_cluster_5 }}</td>
                                <td>{!! $results->motor_cluster_pr_5 !!}</td>
                                <td>{{ $results->motor_cluster_remarks_5 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="assessment-container col-md-12 assessment-page-break" id="ddst-container">
                @include('registration.neuro.assessment_print_header')
                @php $ddst_status = ''; @endphp
                @if ($results->ddst_interpretation_status != null)
                @if ($results->ddst_interpretation_status == 0)
                @php $ddst_status = 'Normal'; @endphp
                @elseif ($results->ddst_interpretation_status == 1)
                @php $ddst_status = 'Delay'; @endphp
                @elseif ($results->ddst_interpretation_status == 2)
                @php $ddst_status = 'Untestable'; @endphp
                @endif
                @endif
                <span id="assessment-status-5" class="hide">Status: {{$ddst_status}}</span>
                <div id="chart-container">
                    <div id="chartdiv"></div>
                </div>
                {!! Form::hidden('ddst_age', $ddst_age) !!}
                {!! Form::hidden('ddst_settings', json_encode(@$ddst_settings)) !!}
            </div>
            <div class="assessment-container col-md-12 assessment-page-break" id="cbcl-container">
                @include('registration.neuro.assessment_print_header')
                @if ($results->cbcl_interpretation_status == 0)
                    @php $cbcl_status = 'Normal'; @endphp
                @elseif ($results->cbcl_interpretation_status == 0)
                    @php $cbcl_status = 'Borderline'; @endphp
                @else
                    @php $cbcl_status = 'Risk'; @endphp
                @endif
                <span id="assessment-status-6" class="hide">Status: {{ $cbcl_status }}</span>
                <div id="cbcl-question-container" class="col-xs-12 plr-must-0 mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="input-width-mini"><b>No.</b></th>
                                <th><b>Question</b></th>
                                <th class="input-width-mini"><b>Status</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cbcl_question as $value)
                                <tr>
                                    <td rowspan="{{ $value->describe == 1 ? '2' : '' }}" >{{ $value->id }}</td>
                                    <td class="text-left">{{ $value->question }}</td>
                                    <td>{{ @$cbcl_result[$value->id]->answer }}</td>
                                </tr>
                                @if ($value->describe == 1)
                                <tr>
                                    <td colspan="2"class="text-left">Describe: {{@$cbcl_result[$value->id]->description}}</td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="problem-container" class="col-xs-12 plr-must-0 mt-15">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><b>Problems</b></th>
                                <th><b>Range</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $cbcl_problems = \ValuelistHelpers::cbclQuestionTypes();
                                $normal_range_text = 'Normal';
                                $medium_range_text = 'Borderline clinical range';
                                $risk_range_text = 'clinical range';
                            @endphp
                            @foreach($cbcl_problems as $key => $value)
                                @if ($key > 0)
                                    @if ($results->cbcl_interpretation_status == 0)
                                        @php $status = $normal_range_text; @endphp
                                    @elseif ($results->cbcl_interpretation_status == 0)
                                        @php $status = $medium_range_text; @endphp
                                    @else
                                        @php $status = $risk_range_text; @endphp
                                    @endif                                
                                    <tr>
                                        <td>{{ $value }}</td>
                                        <td class="input-width-xlarge">{{ $status }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assessment-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            @if (!($hnne_details->total_hnne_score != 0 || $hine_details->total_hine_score != 0 || $m_chat_score != null || $results->cluster_range != null || $results->ddst_interpretation_status != null || count($cbcl_result) > 0))
                <h4>No assessment found</h4>
                <a href="{{ $closewinlink }}" title="back" class="btn close">
                    <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                </a> 
                <!-- <button type="button" class="close btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button> -->
            @else
                <div class="modal-header" style="display: flex; flex-direction: row;">
                    <h5 class="modal-title">
                        <p class="text-center text-white">Select Assessment</p>
                    </h5>
                </div>
                <div class="modal-body m-10">
                    <table>
                        @if ($hnne_details->total_hnne_score != 0)
                        <tr>
                            <td>{!! Form::checkbox('assessment_list[]','HNNE', true) !!}</td>
                            <td>HNNE</td>
                        </tr>
                        @endif
                        @if ($hine_details->total_hine_score != 0)
                        <tr>
                            <td>{!! Form::checkbox('assessment_list[]','HINE', true) !!}</td>
                            <td>HINE</td>
                        </tr>
                        @endif
                        @if ($m_chat_score != null)
                        <tr>
                            <td>{!! Form::checkbox('assessment_list[]','M-CHAT', true) !!}</td>
                            <td>M-CHAT</td>
                        </tr>
                        @endif
                        @if ($results->cluster_range != null)
                        <tr>
                            <td>{!! Form::checkbox('assessment_list[]','DASII', true) !!}</td>
                            <td>DASII</td>
                        </tr>
                        @endif
                        @if ($results->ddst_interpretation_status != null)
                        <tr>
                            <td>{!! Form::checkbox('assessment_list[]', 'DDST', true) !!}</td>
                            <td>DDST II</td>
                        </tr>
                        @endif
                        @if (count($cbcl_result) > 0)
                        <tr>
                            <td>{!! Form::checkbox('assessment_list[]', 'CBCL', true) !!}</td>
                            <td>CBCL</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" id="generate-btn" class="btn btn-primary save-button-shadow"><b>Generate</b></button>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $('#btn-assessment-reset').trigger('click');

        $('#generate-btn').on('click', function() {
            $('.assessment-container').addClass('assessment-page-break');
            
            var very_first_assessment = '';

            $("input:checked").each(function(){
                
                var assessment_name = $(this).val();
                    assessment_name = assessment_name.toLowerCase();

                var assessment_container_name = assessment_name + '-container';

                $('#'+assessment_container_name).addClass('display-block-must');

                if (very_first_assessment == '') {

                    very_first_assessment = assessment_container_name;

                    $('#'+assessment_container_name).removeClass('assessment-page-break');
                    $('#'+assessment_container_name + ' .assessement-header-container').removeClass('assessement-header');                    

                }

            });

            $('#assessment-modal').modal('hide');
        });

        var baby_birth_gestation = (!isNaN($('input[name="assessment_g_weeks"]').val())) ? parseInt($('input[name="assessment_g_weeks"]').val()) : 0;

        $('.selected-score').each(function() {
            var age_group = 'zero_group';
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
            var data_cell = $(this).attr('data-cell');
            var number = data_cell.replace(/[a-z_]/g, '');
                data_cell = data_cell.split(number)[0];
                data_cell = data_cell + 'valid_' + number + '_' + age_group;
            $('.'+data_cell).addClass('selected-cell');
        });
        $('input[name="ddst_age"]').trigger('change');
        var assessment_score_1 = $('#assessment-score-1').html();
        var assessment_score_2 = $('#assessment-score-2').html();

        var assessment_status_1 = $('#assessment-status-1').html();
        var assessment_status_2 = $('#assessment-status-2').html();
        var assessment_status_3 = $('#assessment-status-3').html();
        var assessment_status_4 = $('#assessment-status-4').html();
        var assessment_status_5 = $('#assessment-status-5').html();
        var assessment_status_6 = $('#assessment-status-6').html();

        $('#hnne-container .assessment-score').html(assessment_score_1);
        $('#hine-container .assessment-score').html(assessment_score_2);
        $('#m-chat-container .assessment-block').addClass('hide');
        $('#dasii-container .assessment-block').addClass('hide');
        $('#ddst-container .assessment-score').addClass('hide');
        $('#cbcl-container .assessment-score').addClass('hide');

        $('#hnne-container .assessment-status').html(assessment_status_1);
        $('#hine-container .assessment-status').html(assessment_status_2);
        $('#ddst-container .assessment-status').html(assessment_status_5);
        $('#cbcl-container .assessment-status').html(assessment_status_6);

        $('#assessment-modal').on('hidden.bs.modal', function() {
            $('input[type="checkbox"]').prop('checked', true);
        });

    });

    $(document).on('click', '#btn-assessment-reset', function() {

        $('#assessment-modal').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
        $('#hnne-container').addClass('assessment-page-break').removeClass('display-block-must');
        $('#hine-container').addClass('assessment-page-break').removeClass('display-block-must');
        $('#m-chat-container').addClass('assessment-page-break').removeClass('display-block-must');
        $('#dasii-container').addClass('assessment-page-break').removeClass('display-block-must');
        $('#ddst-container').addClass('assessment-page-break').removeClass('display-block-must');
        $('#cbcl-container').addClass('assessment-page-break').removeClass('display-block-must');
        $('.assessement-header-container').addClass('assessement-header');  

    });
</script>
@endsection
