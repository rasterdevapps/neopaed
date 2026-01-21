    <div class="row">
    	<div class="col-md-5 ">
        <div class="form-group">
          {!! Form::label('name','Name:') !!}
          {!! Form::text('name',$results->name,['class'=>'form-control']) !!}
        </div>  
        <div class="form-group">
          {!! Form::label('qualification','Qualification:') !!}
          {!! Form::text('qualification',$results->qualification,['class'=>'form-control']) !!}
        </div> 
        <div class="form-group">
          {!! Form::label('designation','Designation:') !!}
          {!! Form::text('designation',$results->designation,['class'=>'form-control']) !!}
        </div>                          
        <div class="form-group">
          {!! Form::label('status','Status:') !!}
           {!! Form::select('status',[''=>'--select--','1'=>'Active','0'=>'Inactive'],null,['class'=>'form-control']) !!}
        </div>                        		
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <button type="submit" class="btn btn-primary form-control">
          <i class="fa fa-floppy-o"></i> 
          <span>{!! $SubmitButtonText !!}</span>
        </button>
      </div>
      <div class="col-md-3">
        <a href="{{ action('Masters\StaffController@index') }}" class="btn btn-default form-control" onclick="$('form')[0].reset();">
          <i class="fa fa-exclamation-circle"></i> 
          <span>Cancel</span>
        </a>
      </div>                        
    </div>