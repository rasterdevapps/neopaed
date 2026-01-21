<div class="row">
    <div class="col-xs-12 text-right back-to-screeening">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
</div>
<div class="col-md-12">
    <div class="col-xs-12">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i></h4>
            </div>
            <div class="widget-content">
                <h3>Record of Subtest Scores</h3>
                <table class="table table-bordered" id="record-subtest-score">
                    <thead>
                        <tr>
                            <th>Performance Subtest</th>
                            <th>Raw Score</th>
                            <th>Developmental Age</th>
                            <th>%ile Rank</th>
                            <th>Developmental/adaptive level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="vertical-align-middle">Cognitive/Verbal/Preverbal</td>
                            <td>{!! Form::text('cvp_raw_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('cvp_developemental_age', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('cvp_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('cvp_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Expressive Language</td>
                            <td>{!! Form::text('el_raw_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('el_developemental_age', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('el_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('el_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Receptive Language</td>
                            <td>{!! Form::text('rl_raw_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('rl_developemental_age', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('rl_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('rl_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Fine motor</td>
                            <td>{!! Form::text('fm_raw_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('fm_developemental_age', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('fm_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('fm_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Gross Motor</td>
                            <td>{!! Form::text('gm_raw_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('gm_developemental_age', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('gm_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('gm_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Visual motor imitation</td>
                            <td>{!! Form::text('vmi_raw_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('vmi_developemental_age', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('vmi_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('vmi_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Affective expression</td>
                            <td>{!! Form::text('ae_raw_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('ae_developemental_age', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('ae_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('ae_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Social reciprocity</td>
                            <td>{!! Form::text('sr_raw_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('sr_developemental_age', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('sr_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('sr_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Characteristics motor behaviour</td>
                            <td>{!! Form::text('cmb_raw_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('cmb_developemental_age', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('cmb_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('cmb_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Characteristics verbal behaviour</td>
                            <td>{!! Form::text('cvb_raw_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('cvb_developemental_age', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('cvb_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('cvb_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                    </tbody>
                </table>
                <h3>Record of Composite Scores</h3>
                <table class="table table-bordered" id="record-composite-score">
                    <thead>
                        <tr>
                            <th>Composites</th>
                            <th>Standard Scores</th>
                            <th>%ile Rank</th>
                            <th>Developmental/Adaptive level</th>
                            <th>Developmental Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="vertical-align-middle">Communication</td>
                            <td>{!! Form::text('com_standard_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('com_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('com_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('com_developemental_age', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Motor</td>
                            <td>{!! Form::text('motor_standard_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('motor_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('motor_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('motor_developemental_age', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                        <tr>
                            <td class="vertical-align-middle">Maladaptive behaviours</td>
                            <td>{!! Form::text('mb_standard_score', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('mb_rank', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('mb_development_adaptive_level', null, ['class'=>'form-control']) !!}</td>
                            <td>{!! Form::text('mb_developemental_age', null, ['class'=>'form-control']) !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>
</div>
