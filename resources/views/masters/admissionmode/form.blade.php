    <div class="row select-option-container">
    	<div class="col-md-12">
        <div class="form-group row">
          <div class="col-md-3 text-right label-control">
            {!! Form::label('Mode_name','Mode Name:') !!}
          </div>
          <div class="col-md-9 custom-input">
            {!! Form::text('Mode_name',$results->Mode_name,['class'=>'form-control input-fields-shadow']) !!}
          </div>
        </div>                           
        <div class="form-group row">
          <div class="col-md-3 text-right label-control">
            {!! Form::label('status','Status:') !!}
          </div>
          <div class="col-md-9 custom-input">
           {!! Form::select('Status',['1'=>'Active','0'=>'Inactive'],null,['class'=>'form-control input-fields-shadow']) !!}
         </div>
       </div>                        		
     </div>
     <div class="col-md-12 select-container-main">
      <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium">
        <i class="fa fa-floppy-o"></i> 
        <span>{!! $SubmitButtonText !!}</span>
      </button>
      <a href="{{ action('Masters\AdmissionmodeController@index') }}" class="btn btn-default form-control btn-basic-shadow input-width-medium" onclick="$('form')[0].reset();">
        <i class="fa fa-exclamation-circle"></i> 
        <span>Cancel</span>
      </a>
    </div>
  </div>