<style type="text/css">
    .muscle-tone-norms {
        margin-top: 50px;
    }
    .muscle-tone-norms .table-bordered > thead > tr > th {
        vertical-align: top;
    }
    .muscle-tone-norms .table-bordered > tbody > tr > td {
        text-align: left !important;
        vertical-align: middle;
        padding: 0px 8px;
    }
    .muscle-tone-norms input[type="text"] {
        border: none;
        box-shadow: unset;
        background-color: unset !important;
        margin-bottom: unset;
        border-radius: 0px;
        text-align: center;
        border-bottom: 1px solid var(--theme-color);
    }
    .muscle-tone-norms input[type="text"]:focus {
        border: none;
        outline: none;
        box-shadow: unset;
        border-bottom: 1px solid #1e1e2d;
    }
    .muscle-tone-norms input[type="checkbox"] {
        width: 20px;
        height: 20px;
    }
    .muscle-tone-norms .table-bordered > tbody > tr > td.text-center {
        text-align: center !important;
    }
    .muscle-tone-norms td div {
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .muscle-tone-norms td div .fas.fa-edit, .muscle-tone-norms td div .fas.fa-calendar-day {
        color: var(--bg-theme-light);
        font-size: 12px;
        display: none;
    }
</style>
<div class="muscle-tone-norms">
    <h6><strong>Muscle tone norms (Amiel Tison):</strong></h6>
    <div class="overflow-auto">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="3" class="vertical-align-center">Age<br/>(month)</th>
                    <th rowspan="3" class="vertical-align-center">Date of<br/>assessment</th>
                    <th rowspan="3" class="vertical-align-center">PNA/CA at<br/>assessment</th>
                    <th rowspan="3" class="vertical-align-center">Adductor angle</th>
                    <th colspan="2">As assessed</th>
                    <th rowspan="3" class="vertical-align-center">Popliteal angle</th>
                    <th colspan="2">As assessed</th>
                    <th rowspan="3" class="vertical-align-center">Dorsiflexion angle</th>
                    <th colspan="2">As assessed</th>
                    <th colspan="6">Scarf sign (tick)</th>
                </tr>
                <tr>
                    <th rowspan="2" class="vertical-align-center">Left</th>
                    <th rowspan="2" class="vertical-align-center">Right</th>
                    <th rowspan="2" class="vertical-align-center">Left</th>
                    <th rowspan="2" class="vertical-align-center">Right</th>
                    <th rowspan="2" class="vertical-align-center">Left</th>
                    <th rowspan="2" class="vertical-align-center">Right</th>
                    <th colspan="2" class="vertical-align-center">Elbow does not cross midline</th>
                    <th colspan="2" class="vertical-align-center">Elbow crosses midline</th>
                    <th colspan="2" class="vertical-align-center">Elbow goes beyond axillary line</th>
                </tr>
                <tr>
                    <th>Left</th>
                    <th>Right</th>
                    <th>Left</th>
                    <th>Right</th>
                    <th>Left</th>
                    <th>Right</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">0-3</td>
                    <td class="text-center">{!! Form::text('date_of_assessment_0_3', null, ['class'=>'form-control assessment_date assessment_date_0-3']) !!}</td>
                    <td class="text-center">{!! Form::text('pna_ca_assessment_0_3', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">40°-80°</td>
                    <td class="text-center">{!! Form::text('adductor_as_assessed_left_0_3', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('adductor_as_assessed_right_0_3', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">80°-100°</td>
                    <td class="text-center">{!! Form::text('popliteal_as_assessed_left_0_3', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('popliteal_as_assessed_right_0_3', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">60°-70°</td>
                    <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_left_0_3', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_right_0_3', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_left_0_3', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_right_0_3', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_cross_midline_left_0_3', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_cross_midline_right_0_3', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_left_0_3', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_right_0_3', null) }}</td>
                </tr>
                <tr>
                    <td class="text-center">4-6</td>
                    <td class="text-center">{!! Form::text('date_of_assessment_4_6', null, ['class'=>'form-control assessment_date assessment_date_4-6']) !!}</td>
                    <td class="text-center">{!! Form::text('pna_ca_assessment_4_6', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">70°-110°</td>
                    <td class="text-center">{!! Form::text('adductor_as_assessed_left_4_6', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('adductor_as_assessed_right_4_6', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">90°-120°</td>
                    <td class="text-center">{!! Form::text('popliteal_as_assessed_left_4_6', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('popliteal_as_assessed_right_4_6', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">60°-70°</td>
                    <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_left_4_6', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_right_4_6', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_left_4_6', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_right_4_6', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_cross_midline_left_4_6', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_cross_midline_right_4_6', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_left_4_6', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_right_4_6', null) }}</td>
                </tr>
                <tr>
                    <td class="text-center">7-9</td>
                    <td class="text-center">{!! Form::text('date_of_assessment_7_9', null, ['class'=>'form-control assessment_date assessment_date_7-9']) !!}</td>
                    <td class="text-center">{!! Form::text('pna_ca_assessment_7_9', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">110°-140°</td>
                    <td class="text-center">{!! Form::text('adductor_as_assessed_left_7_9', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('adductor_as_assessed_right_7_9', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">110°-160°</td>
                    <td class="text-center">{!! Form::text('popliteal_as_assessed_left_7_9', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('popliteal_as_assessed_right_7_9', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">60°-70°</td>
                    <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_left_7_9', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_right_7_9', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_left_7_9', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_right_7_9', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_cross_midline_left_7_9', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_cross_midline_right_7_9', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_left_7_9', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_right_7_9', null) }}</td>
                </tr>
                <tr>
                    <td class="text-center">10-12</td>
                    <td class="text-center">{!! Form::text('date_of_assessment_10_12', null, ['class'=>'form-control assessment_date assessment_date_10-12']) !!}</td>
                    <td class="text-center">{!! Form::text('pna_ca_assessment_10_12', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">140°-160°</td>
                    <td class="text-center">{!! Form::text('adductor_as_assessed_left_10_12', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('adductor_as_assessed_right_10_12', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">150°-170°</td>
                    <td class="text-center">{!! Form::text('popliteal_as_assessed_left_10_12', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('popliteal_as_assessed_right_10_12', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">60°-70°</td>
                    <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_left_10_12', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{!! Form::text('dorsiflexion_as_assessed_right_10_12', null, ['class'=>'form-control']) !!}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_left_10_12', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_not_cross_midline_right_10_12', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_cross_midline_left_10_12', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_cross_midline_right_10_12', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_left_10_12', null) }}</td>
                    <td class="text-center">{{ Form::checkbox('elbow_goes_beyond_axillary_line_right_10_12', null) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-12 mt-15">        
        <div class="col-sm-12 col-md-6">        
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('tone_type','Tone:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::select('tone_type', ValuelistHelpers::toneoption(),null,['class'=>'form-control']) !!}
                </div>
            </div>        
        </div>        
        <div class="col-sm-12 col-md-6">        
            <div class="form-group row">
                <div class="col-md-3 text-right label-control">
                    {!! Form::label('others','Others:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::select('others',ValuelistHelpers::otheroption(),null,['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="form-group row" id="others-asymmetric">
                <div class="col-md-offset-3 col-md-9 custom-input">
                    {!! Form::textarea('others_asymmetric',null,['class'=>'form-control', 'rows'=>5]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.assessment_date').datepicker({ dateFormat: 'dd-mm-yy' });
        $("#screening select[name='others']").trigger('change');
    });
    $(document).on("change", "#screening select[name='others']", function() {
        if ($("#screening select[name='others']").val() == 2) {
            $("#others-asymmetric").show();
        } else {
            $("#others-asymmetric").hide();                
        }
    });
</script>