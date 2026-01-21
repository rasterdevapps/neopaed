<div class="row">
	<div class="col-md-5 ">
    <div class="form-group">
       {!! Form::label('Name','Brand Name:') !!}
       {!! Form::text('Name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
       {!! Form::label('generic_name','Generic Name (pharmacological name):') !!}
       {!! Form::text('generic_name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
       {!! Form::label('Value','Value:') !!}
       {!! Form::text('Value',null,['class'=>'form-control']) !!}
    </div>     
    <div class="form-group">
       {!! Form::label('Status','Status:') !!}
       {!! Form::select('Status',['Active'=>'Active','Inactive'=>'Inactive'],null,['class'=>'form-control']) !!}
    </div>                        		
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <button type="submit" class="btn btn-createnew-shadow btn-primary form-control">
      <i class="fa fa-floppy-o"></i> 
      <span>{!! $SubmitButtonText !!}</span>
    </button>
  </div>
  <div class="col-md-3">
    <a href="{{ action('Masters\DrugAndInfusionController@index') }}" class="btn btn-default btn-createnew-shadow form-control" onclick="$('form')[0].reset();">
      <i class="fa fa-exclamation-circle"></i> 
      <span>Cancel</span>
    </a>
  </div>
</div>                         