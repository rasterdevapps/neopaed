<div class="col-md-4 col-sm-12 hidden-md hidden-sm hidden-xs">
    <div class="mt-10 widget box">
        <div class="widget-header">
            <h4><i class="fa fa-reorder"></i> Baby Info</h4>
        </div>
        <div class="widget-content">
            <div class="form-group row">
                <div class="col-md-3 text-right label-control col-sm-5">
                    Baby's Name: 
                </div>
                <div class="col-md-9 custom-input col-sm-5">
                    {!! $baby_details->BabyName !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control col-sm-5">
                    {{ Lang::get('home.mrn') }}: 
                </div>
                <div class="col-md-9 custom-input col-sm-5">
                    {!! $baby_details->BMrNo !!}   
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control col-sm-5">
                    {{ Lang::get('home.ip') }}: 
                </div>
                <div class="col-md-9 custom-input col-sm-5">
                    {!! isset($ip_details->ip_number) ? $ip_details->ip_number : '' !!} 
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control col-sm-5">
                    Sex: 
                </div>
                <div class="col-md-9 custom-input col-sm-5">
                    {!! $baby_details->Sex !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control col-sm-5">
                    DOB: 
                </div>
                <div class="col-md-9 custom-input col-sm-5">
                    @if(!is_null($baby_details->DOB)) 
                    {!! date('d-m-Y',strtotime($baby_details->DOB)) !!} @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control col-sm-5">
                    Gestation: 
                </div>
                <div class="col-md-9 custom-input col-sm-5">
                    {!! SiteHelpers::decode_gestation($baby_details->Gestation) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control col-sm-5">
                    Corrected Gestational Age: 
                </div>
                <div class="col-md-9 custom-input col-sm-5">
                    {!! $corrected_gestation !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right label-control col-sm-5">
                    Birth Weight: 
                </div>
                <div class="col-md-9 custom-input col-sm-5">
                    {!! $baby_details->BirthWeight !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-8 col-md-12 col-sm-12 px-0">
    <div class="col-md-12 col-sm-12 px-0">
        <div class="mt-10 widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> </h4>
            </div>
            <div class="widget-content row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('current_weight','Current Weight:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('current_weight',@$baby_details->current_weight,['class'=>'form-control input-fields-shadow not_saved permanant_saved', 'id'=>'current_weight', 'onkeypress'=>'return isNumber(event, this);']) !!}
                            <span class="error-message hide" id="current-weight-error">Please enter a valid current weight</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('working_weight','Working Weight:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('working_weight',@$baby_details->working_weight,['class'=>'form-control calculate-glucose input-fields-shadow not_saved permanant_saved', 'id'=>'working_weight', 'onkeypress'=>'return isNumber(event, this);']) !!}
                            <span class="error-message hide" id="working-weight-error">Please enter a valid working weight</span>
                        </div>
                    </div>
                </div>
                @php 
                $baby_details->et_size = isset($baby_details->et_size) && !empty($baby_details->et_size) ? $baby_details->et_size : null;
                $baby_details->et_length = isset($baby_details->et_length) && !empty($baby_details->et_length) ? $baby_details->et_length : null;
                $ett_status = (isset($baby_details->ett_status) && ($baby_details->ett_status || $baby_details->et_size != null || $baby_details->et_length != null)) ? 'Yes' : 'No';
                @endphp
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">    
                            {!! Form::label('ett_status','ETT Status:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <input id="ett_status" data-size="small" name="ett_status" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input not_saved permanant_saved" type="checkbox" @if(isset($ett_status) && $ett_status == 'Yes') checked="checked" @endif>
                        </div>
                    </div>
                    <div class="form-group row ett-enable @if(isset($ett_status) && !($ett_status == 'Yes')) display-none @endif">
                        <div class="col-md-3 text-right label-control">    
                            {!! Form::label('et_size','ETT Size:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('et_size',$baby_details->et_size,['class'=>'form-control input-fields-shadow not_saved permanant_saved']) !!}
                        </div>
                    </div>
                    <div class="form-group row ett-enable @if(isset($ett_status) && !($ett_status == 'Yes')) display-none @endif">
                        <div class="col-md-3 text-right label-control">    
                            {!! Form::label('et_length','ETT Length:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('et_length',$baby_details->et_length,['class'=>'form-control input-fields-shadow not_saved permanant_saved']) !!}
                        </div>
                    </div>
                </div>
                @php 
                $baby_details->ngt_size = isset($baby_details->ngt_size) && !empty($baby_details->ngt_size) ? $baby_details->ngt_size : null;
                $baby_details->ngt_length = isset($baby_details->ngt_length) && !empty($baby_details->ngt_length) ? $baby_details->ngt_length : null;
                $ngt_status = (isset($baby_details->ngt_status) && ($baby_details->ngt_status || $baby_details->ngt_size != null || $baby_details->ngt_length != null)) ? 'Yes' : 'No';
                @endphp
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">    
                            {!! Form::label('ngt_status','NGT Status:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <input id="ngt_status" data-size="small" name="ngt_status" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input not_saved permanant_saved" type="checkbox" @if(isset($ngt_status) && $ngt_status == 'Yes') checked="checked" @endif>
                        </div>
                    </div>
                    <div class="form-group row ngt-enable @if(isset($ngt_status) && !($ngt_status == 'Yes')) display-none @endif">
                        <div class="col-md-3 text-right label-control">    
                            {!! Form::label('ngt_size','NGT Size:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('ngt_size',$baby_details->ngt_size,['class'=>'form-control input-fields-shadow not_saved permanant_saved']) !!}    
                        </div>
                    </div>
                    <div class="form-group row ngt-enable @if(isset($ngt_status) && !($ngt_status == 'Yes')) display-none @endif">
                        <div class="col-md-3 text-right label-control">    
                            {!! Form::label('ngt_length','NGT Length:') !!}
                        </div>
                        <div class="col-md-9 custom-input">                    
                            {!! Form::text('ngt_length',$baby_details->ngt_length,['class'=>'form-control input-fields-shadow not_saved permanant_saved']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
