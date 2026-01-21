<div class="col-md-12 col-sm-12">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('is_parent_concerns','Parent Concerns:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <input id="is_parent_concerns" name="is_parent_concerns" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" @if(@$results->is_parent_concerns) checked="checked" @endif">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <div id="parent_concerns" class="tinymce-body">
                                {!! isset($results->parent_concerns) ? $results->parent_concerns : @$baby_detail->parent_concerns !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('is_current_feeding','Current Feeding:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <input id="is_current_feeding" name="is_current_feeding" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" @if(@$results->is_current_feeding)s checked="checked" @endif">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <div id="current_feeding" class="tinymce-body">
                                {!! isset($results->current_feeding) ? $results->current_feeding : @$baby_detail->current_feeding !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('is_oral_motor_assessment','Oral Motor Assessment:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <input id="is_oral_motor_assessment" name="is_oral_motor_assessment" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" @if(@$results->is_oral_motor_assessment) checked="checked" @endif>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <div id="oral_motor_assessment" class="tinymce-body">
                                {!! isset($results->oral_motor_assessment) ? $results->oral_motor_assessment : @$baby_detail->oral_motor_assessment !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('is_cranial_nerve_assesment','Cranial Nerve Assesment:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <input id="is_cranial_nerve_assesment" name="is_cranial_nerve_assesment" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" @if(@$results->is_cranial_nerve_assesment) checked="checked" @endif">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <div id="cranial_nerve_assesment" class="tinymce-body">
                                {!! isset($results->cranial_nerve_assesment) ? $results->cranial_nerve_assesment : @$baby_detail->cranial_nerve_assesment !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('is_feeding_assesment','Feeding Assesment:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <input id="is_feeding_assesment" name="is_feeding_assesment" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" @if(@$results->is_feeding_assesment) checked="checked" @endif>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <div id="feeding_assesment" class="tinymce-body">
                                {!! isset($results->feeding_assesment) ? $results->feeding_assesment : @$baby_detail->feeding_assesment !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('is_mothers_examination','Mothers Examination:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <input id="is_mothers_examination" name="is_mothers_examination" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" @if(@$results->is_mothers_examination) checked="checked" @endif>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <div id="mothers_examination" class="tinymce-body">
                                {!! isset($results->mothers_examination) ? $results->mothers_examination : @$baby_detail->mothers_examination !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('is_interpretation','Interpretation:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <input id="is_interpretation" name="is_interpretation" data-on="Yes" data-off="No" data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox" @if(@$results->is_interpretation) checked="checked" @endif>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <div id="interpretation" class="tinymce-body">
                                {!! isset($results->interpretation) ? $results->interpretation : @$baby_detail->interpretation !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('recommendation','Recommendation:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <div id="recommendation" class="tinymce-body">
                                {!! isset($results->recommendation) ? $results->recommendation : @$baby_detail->recommendation !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('appointment_type','Current Appointment Type:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('appointment_type',[' '=>'N/A']+ValuelistHelpers::appointmentType(),null,['class'=>'select2-select-00 full-width']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                            {!! Form::label('Review','Review:') !!}
                        </div>
                        <div class="col-md-9 custom-input clear-xs">
                            <div class="col-xs-3 plr-0">
                                <small>(Date)</small>
                            </div>
                            <div class="col-xs-3">
                                <small>(Days)</small>
                            </div>
                            <div class="col-xs-6 plr-0">
                                <small>(Time)</small>
                            </div>
                            <div class="col-xs-3 plr-0">
                                {!! Form::text('review',null,['class'=>'form-control datepicker', 'readonly']) !!}
                            </div>
                            <div class="col-xs-3">
                                {!! Form::text('review_days',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="col-xs-6 plr-0">
                                <div class="col-xs-4 plr-0">{!! Form::select('review_time',$time['time'],null,['class'=>'form-control']) !!}</div>
                                <div class="col-xs-4 pl-5 pr-0">{!! Form::select('review_min',$time['mins'],null,['class'=>'form-control']) !!}</div>
                                <div class="col-xs-4 pl-5 pr-0">{!! Form::select('review_session',$time['session'],null,['class'=>'form-control']) !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="fee_status">Fee charges:</label>
                        </div>
                        <div class="col-md-9 custom-input"> 
                            <input id="fee_status" data-size="small" name="fee_status" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($results->fee_status) && $results->fee_status == 'Yes') checked="checked" @endif>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('no_fee_reason','Reason:') !!}
                        </div>
                        <div class="col-md-9 custom-input"> 
                            {!! Form::text('no_fee_reason',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('fee_amount','Fee Amount: (&#8377;)') !!}
                        </div>
                        <div class="col-md-9 custom-input"> 
                            {!! Form::text('fee_amount',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>