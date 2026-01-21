	<div class="col-md-5">
	  <div class="form-group">
	  	   {!! Form::label('dSummaryedit','Detailed Original Summary:') !!}
	  	   <input type="checkbox" name="permissions[]" value="DISCHARGE_EDIT" @if(in_array('DISCHARGE_EDIT', $permission_status)) checked @endif class="uniform">
	  </div>
	  <div class="form-group">
	  	   {!! Form::label('aSummaryedit','Abbreviated Edited Summary:') !!}
	  	   <input type="checkbox" name="permissions[]" value="ABBREVIATED_DISCHARGE_EDIT" @if(in_array('ABBREVIATED_DISCHARGE_EDIT', $permission_status)) checked @endif class="uniform">
	  </div>		
	</div>
	<div class="col-md-5">
        <div class="form-group">
	  	   {!! Form::label('smsNotify','SMS:') !!}
	  	   <input type="checkbox" name="permissions[]" value="SMS_SENT" @if(in_array('SMS_SENT', $permission_status)) checked @endif class="uniform">
	    </div>	
		
	</div>

