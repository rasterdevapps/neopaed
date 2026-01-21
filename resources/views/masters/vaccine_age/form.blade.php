<div class="row select-option-container">
	<div class="col-md-12">
    <div class="form-group row">
      <div class="col-md-3 text-right label-control">
       {!! Form::label('Name','Brand Name:') !!}
     </div>
     <div class="col-md-9 custom-input">
       {!! Form::text('Name',null,['class'=>'form-control input-fields-shadow']) !!}
      </div>
    </div>
    <div class="form-group row">
      <div class="col-md-3 text-right label-control mt-0">
       {!! Form::label('generic_name','Generic Name (pharmacological name):') !!}
     </div>
     <div class="col-md-9 custom-input">
       {!! Form::text('generic_name',null,['class'=>'form-control input-fields-shadow']) !!}
      </div>
    </div>
    <div class="form-group row">
      <div class="col-md-3 text-right label-control">
       {!! Form::label('Value','Value:') !!}
     </div>
     <div class="col-md-9 custom-input">
       {!! Form::text('Value',null,['class'=>'form-control input-fields-shadow']) !!}
      </div>
    </div>     
    <div class="form-group row">
      <div class="col-md-3 text-right label-control">
       {!! Form::label('Status','Status:') !!}
     </div>
     <div class="col-md-9 custom-input">
       {!! Form::select('Status',['Active'=>'Active','Inactive'=>'Inactive'],null,['class'=>'form-control input-fields-shadow']) !!}
      </div>
    </div>                        		
  </div>
  <div class="col-md-12 select-container-main">
    <button type="submit" class="btn btn-basic-shadow btn-primary form-control input-width-medium">
      <i class="fa fa-floppy-o"></i> 
      <span>{!! $SubmitButtonText !!}</span>
    </button>
    <a href="{{ action('Masters\DrugController@index') }}" class="btn btn-default btn-basic-shadow form-control input-width-medium" onclick="$('form')[0].reset();">
      <i class="fa fa-exclamation-circle"></i> 
      <span>Cancel</span>
    </a>
  </div>
</div>                         
