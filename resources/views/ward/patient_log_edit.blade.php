

<!--=== Page Content ===-->
<div class="row row-spacing">
 {!! Form::model($results,['method'=> 'PATCH','url' => action('Ward\PatientLogHistoryController@update',$id),'id'=>'bed-log-edit']) !!}

	<div class="col-md-12">
        <div class="col-md-6 col-sm-6">
        	<div class="form-group">
		       {!! Form::label('BMrNo','B'.Lang::get('home.mrn').':') !!}
               {!! Form::text('BMrNo',null,['class'=>'form-control','readonly'=>'true']) !!}
    		</div>
        	<div class="form-group">
        	   {!! Form::label('BabyName','Baby Name:') !!}
		       {!! Form::text('BabyName',null,['class'=>'form-control','readonly'=>'true']) !!}
        	</div>
        	<div class="form-group">
        		@php $dob = isset($results->DOB) ? date('d-m-Y', strtotime($results->DOB)): null; @endphp
        	   {!! Form::label('DOB','DOB:') !!}
		       {!! Form::text('DOB',$dob,['class'=>'form-control','readonly'=>'true']) !!}
        	</div>
        </div>
        <div class="col-md-6 col-sm-6">
        	<div class="form-group">
        		{!! Form::label('ward_name', 'Ward Name') !!}
        		{!! Form::select('ward_name', [''=>'N/A']+$ward, @$results->ward_id,['class'=>'form-control'])!!}
        	</div>
        	<div class="form-group">
        		{!! Form::label('room_no', 'Room No') !!}
        		{!! Form::select('room_no', [''=>'N/A']+$room, @$results->room_id,['class'=>'form-control'])!!}

        	</div>
        	<div class="form-group">
        		{!! Form::label('bed_no', 'Bed No') !!}
        		{!! Form::select('bed_no', [''=>'N/A']+$bed, @$results->bed_id,['class'=>'form-control'])!!}
        	</div>
        </div>
    </div> <!-- /.col-md-12 -->   
    <div class="row">
		<div class="col-md-3 pull-right">
		    <button type="button" class="btn btn-primary form-control update-bed-log btn-basic-shadow width-72">
		    	<i class="fa fa-floppy-o"></i> 
		    	<span>Save</span>
		    </button>
		</div>
		
	</div>
        {!! Form::close() !!} 
</div> <!-- /.row -->
<!-- /Page Content -->
              

<script type="text/javascript">
$('select[name="room_no"]').change(function(){
	var roomNo = $(this).val();
	$.ajax({
           type:'GET',
           url:'{{ url("get-bed-details") }}'+'/'+roomNo,
           beforeSend:function() {
           },
           success:function(responseText) {

           	var list = '<option value="">N/A</option>';
           	$.each(responseText.bed_list, function(index, value) {
           	  	list += '<option value="'+index+'">'+value+'</option>';
           	});
           	$('select[name="bed_no"]').html(list);

           },
           complete:function(responseText) {
           },
           error:function(responseText) {
           }

    });


});
</script>
