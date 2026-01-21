<div class="col-md-12 plr-0">
    <div class="col-md-6 col-sm-6">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> Input:</h4>
            </div>
            <div class="widget-content">
                <div class="form-group">
                    {!! Form::label('intravenous_fluids','Intravenous Fluids(ml) PN and Drug Infusions:') !!}
                    {!! Form::number('intravenous_fluids',null,['class'=>'form-control not_saved permanant_saved'])!!}
                </div>
                <div class="form-group">
                    {!! Form::label('oral_fluids','Oral Fluids(ml):') !!}
                    {!! Form::number('oral_fluids',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('other_drugs','Other IV Drugs (ml) (please enter value manually):') !!}
                    {!! Form::number('other_drugs',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('total_intake_ml','Total Fluids (ml):') !!}
                    {!! Form::number('total_intake_ml',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('total_intake_kg','Total Fluids (ml/kg/day):') !!}
                    {!! Form::number('total_intake_kg',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <br/><br/>
                <h4><u><b>Balance</b></u></h4>
                <div class="form-group">
                    {!! Form::label('i_o_balance','I/O Balance (ml):') !!}
                    {!! Form::number('i_o_balance',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('i_o_balance_ml_kg','I/O Balance (ml/kg/day):') !!}
                    {!! Form::number('i_o_balance_ml_kg',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> Output:</h4>
            </div>
            <div class="widget-content">
                <div class="form-group">
                    {!! Form::label('aspirate_ml','Aspirate (ml):') !!}
                    {!! Form::number('aspirate_ml',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('drains_ml','Drains (ml):') !!}
                    {!! Form::number('drains_ml',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('urine_total','Urine Total (ml):') !!}
                    {!! Form::number('urine_total',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('urine_total_full_day','24 Hour Urine Output (ml/kg/day):') !!}
                    {!! Form::number('urine_total_full_day',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('urine_total_ml_kg','Spot Urine (ml/kg/hour):') !!}
                    {!! Form::number('urine_total_ml_kg',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('blood_out_total','Blood Out Total (ml):') !!}
                    {!! Form::number('blood_out_total',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('stools_frequency','Stools (Frequency):') !!}
                    {!! Form::number('stools_frequency',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('stoma_output','Stoma Output (ml):') !!}
                    {!! Form::number('stoma_output',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('total_output','Total Output (ml):') !!}
                    {!! Form::number('total_output',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('total_output_ml_day','Total Output (ml/kg/day):') !!}
                    {!! Form::number('total_output_ml_day',null,['class'=>'form-control not_saved permanant_saved']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
