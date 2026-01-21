					<div class="row select-option-container">
						<div class="col-md-12">
             <div class="form-group row">
              <div class="col-md-3 text-right label-control">
               {!! Form::label('Name','Name:') !!}
             </div>
             <div class="col-md-9 custom-input">
              {!! Form::text('Name',null,['class'=>'form-control input-fields-shadow']) !!}
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
      <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium"><i class="fa fa-floppy-o"></i> <span>{!! $SubmitButtonText !!}</span></button>
      <a href="{{ action('Masters\VaccineController@index') }}" class="btn btn-default form-control btn-basic-shadow input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
    </div>
  </div>