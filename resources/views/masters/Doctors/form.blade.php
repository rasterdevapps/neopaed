    <div class="row select-option-container">
    	<div class="col-md-12">
        <div class="form-group col-md-12 mb-15 plr-0">
          <div class="col-md-3 text-right label-control">
            {!! Form::label('Name','Name:') !!}
          </div>
          <div class="col-md-9 plr-0">
            <div class="col-md-12 pr-0" style="padding-left: 7px;">
              <div class="col-md-3 plr-0">{!! Form::text('name_prefix',($results->type == 3 ? '' : 'Dr'),['class'=>'form-control input-fields-shadow','readonly'=>true]) !!}</div>
              <div class="col-md-9 plr-0">{!! Form::text('Name',null,['class'=>'form-control input-fields-shadow']) !!}</div>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-3 text-right label-control">
            {!! Form::label('Qualification','Qualification:') !!}
          </div>
          <div class="col-md-9 custom-input">
            {!! Form::text('Qualification',null,['class'=>'form-control input-fields-shadow']) !!}
          </div>
        </div> 
        <div class="form-group row">
          <div class="col-md-3 text-right label-control">
            {!! Form::label('job_title', 'Job Title:') !!}
          </div>
          <div class="col-md-9 custom-input">
            {!! Form::text('job_title',null,['class'=>'form-control input-fields-shadow']) !!}
          </div>
        </div> 
        <div class="form-group row">
          <div class="col-md-3 text-right label-control">
            {!! Form::label('register_no', 'Reg. No:') !!}
          </div>
          <div class="col-md-9 custom-input">
            {!! Form::text('register_no',null,['class'=>'form-control input-fields-shadow']) !!}
          </div>
        </div> 
        <div class="form-group row">
          <div class="col-md-3 text-right label-control">
            {!! Form::label('type','Type:') !!}
          </div>
          <div class="col-md-9 custom-input">
           {!! Form::select('type',['1'=>'Doctor','2'=>'Surgon','3'=>'Others'],null,['class'=>'form-control input-fields-shadow']) !!}
         </div>
       </div>                                
       <div class="form-group row">
        <div class="col-md-3 text-right label-control">
          {!! Form::label('status','Status:') !!}
        </div>
        <div class="col-md-9 custom-input">
         {!! Form::select('status',['1'=>'Active','0'=>'Inactive'],null,['class'=>'form-control input-fields-shadow']) !!}
       </div>
     </div>                        		
   </div>
  <div class="col-md-12 select-container-main">
    <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium">
      <i class="fa fa-floppy-o"></i> 
      <span>{!! $SubmitButtonText !!}</span>
    </button>
    <a href="{{ action('Masters\DoctorController@index') }}" class="btn btn-default form-control btn-basic-shadow input-width-medium" onclick="$('form')[0].reset();">
      <i class="fa fa-exclamation-circle"></i> 
      <span>Cancel</span>
    </a>
  </div>
 </div>
