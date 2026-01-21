<div class="row select-option-container">
	<div class="col-md-12">
    <div class="form-group row">
      <div class="col-md-3 text-right label-control">
        {!! Form::label('name','Name:') !!}
      </div>
      <div class="col-md-9 custom-input">
        {!! Form::text('name',null,['class'=>'form-control input-fields-shadow']) !!}
      </div>
    </div>
    <div class="form-group row">
      <div class="col-md-3 text-right label-control">
        {!! Form::label('register_no','Register No.:') !!}
      </div>
      <div class="col-md-9 custom-input">
        {!! Form::text('register_no',null,['class'=>'form-control input-fields-shadow']) !!}
      </div>
    </div>                            
    <div class="form-group row">
      <div class="col-md-3 text-right label-control">
        {!! Form::label('status','Status:') !!}
      </div>
      <div class="col-md-9 custom-input">
        {!! Form::select('status',['Active'=>'Active','Inactive'=>'Inactive'],null,['class'=>'form-control input-fields-shadow']) !!}
      </div>
    </div>                        		
  </div>
  <div class="col-md-12 select-container-main">
    <button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium">
      <i class="fa fa-floppy-o"></i><span>{!! $SubmitButtonText !!}</span>
    </button>
    <a href="{{ action('Masters\NurseController@index') }}" class="btn btn-default btn-basic-shadow form-control input-width-medium" onclick="$('form')[0].reset();">
      <i class="fa fa-exclamation-circle"></i> <span>Cancel</span>
    </a>
  </div>
</div>
