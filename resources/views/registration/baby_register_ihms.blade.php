<div class="modal fade" id="create_baby_details" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modal-fixed">     
      <div class="modal-header" >
                <button type="button" class="close color-white" data-dismiss="modal" aria-hidden="true">x</button>
    			<h4 id="myModalLabel" class="modal-title color-white text-center">Register Baby</h4>
			     </div>
      <div class="modal-body modal-body-all">
      <div></div>
      <div><h4 class="font-babyname font-bold">Baby Info</h4></div>
      <form class="form-horizontal">
        {!! Form::open(['url'=>'','method'=>'get','id'=>'baby-register']) !!} 
        <div class="row">
      
         <div class="col-md-6">         
              <div class="form-group">
              <span class="col-md-4">{!! Form::label('BabyName','Baby Name:') !!}</span>
              <span class="col-md-8">{!! Form::text('BabyName',null,['class'=>'form-control']) !!}</span>
              </div>

               <div class="form-group">
               <span class="col-md-4">{!! Form::label('BMrNo','Baby '.Lang::get('home.mrn').':') !!}</span>
               <span class="col-md-8">{!! Form::text('BMrNo',null,['class'=>'form-control']) !!}</span>
              </div> 
             
              <div class="form-group">
              <span class="col-md-4">{!! Form::label('DOB','Date of Birth:') !!}</span>
              <span class="col-md-8">{!! Form::text('DOB',null,['class'=>'form-control datepicker']) !!}</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              <span class="col-md-4">{!! Form::label('Sex','Sex:') !!}</span>
              <span class="col-md-8">{!! Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) !!}</span>
              </div>    
              <div class="form-group">
              <span class="col-md-4"> {!! Form::label('Ipnumber', Lang::get('home.ip')) !!}</span>
              <span class="col-md-8">{!! Form::text('Ipnumber',null,['class'=>'form-control']) !!}</span>
              </div>
          
             <div class="form-group">
               <span class="col-md-4">{!! Form::label('TOB','TOB:') !!}</span>
               <span class="col-md-8">
               <span class="col-md-4">  {!! Form::select('TOB_TIME',$tob['time'],null,['class'=>'form-control input-width-mini']) !!}</span>
               <span class="col-md-4">  {!! Form::select('TOB_MINS',$tob['mins'],null,['class'=>'form-control input-width-mini']) !!}</span>
               <span class="col-md-4">   {!! Form::select('TOB_AM',['AM'=>'AM','PM'=>'PM'],null,['class'=>'form-control input-width-mini']) !!}</span>
              </span>            
            </div> 
          </div>     
         </div> 
        
         <div> <h4 class="font-babyname font-bold">Mother Info</h4></div>
          <div class="row">
             <div class="col-md-6">         
                <div class="form-group">
                <span class="col-md-4">{!! Form::label('MotherName','Mother Name:') !!}</span>
                <span class="col-md-8">{!! Form::text('MotherName',null,['class'=>'form-control']) !!}</span>
                </div>
                <div class="form-group">
                <span class="col-md-4">{!! Form::label('Mobile','Contact No 1:') !!}</span>
                <span class="col-md-8">{!! Form::text('Mobile',null,['class'=>'form-control']) !!}</span>
                </div>
                 <div class="form-group">
                 <span class="col-md-4">{!! Form::label('Address1','Address Line 1  :') !!}</span>
                 <span class="col-md-8">{!! Form::text('Address1',null,['class'=>'form-control']) !!}</span>
                </div>
                <div class="form-group">
                <span class="col-md-4">{!! Form::label('Address3','City:') !!}</span>
                <span class="col-md-8">{!! Form::text('Address3',null,['class'=>'form-control']) !!}</span>
                </div>
             </div>
             <div class="col-md-6">
                <div class="form-group">
                <span class="col-md-4">{!! Form::label('PartnerName','Father Name:') !!}</span>
                <span class="col-md-8">{!! Form::text('PartnerName',null,['class'=>'form-control']) !!}</span>
                </div>
                <div class="form-group">
                <span class="col-md-4"> {!! Form::label('LandLine','Contact No 2:') !!}</span>
                <span class="col-md-8">{!! Form::text('LandLine',null,['class'=>'form-control']) !!}</span>
                </div>
                <div class="form-group">
                <span class="col-md-4">{!! Form::label('Address2','Address Line 2:') !!}</span>
                <span class="col-md-8">{!! Form::text('Address2',null,['class'=>'form-control']) !!}</span>
                </div>
                <div class="form-group">
                <span class="col-md-4">{!! Form::label('Address4',' Pin/Zip code:') !!}</span>
                <span class="col-md-8">{!! Form::text('Address4',null,['class'=>'form-control']) !!}</span>
                </div>
             </div>
             <div class="col-md-3 pull-right"><button class="btn save-baby btn-primary btn-block">Save</button></div>
         </div> 
        {!! Form::close() !!}  
        </form>             
      </div>
      <div class="modal-footer border-tnone">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('.save-baby').click(function(e){
      e.preventDefault();
       $.ajax({
               type    :"POST",
               url     :"{{ url('create-baby-mother') }}",
               data    :$('#baby-register').serialize(),
               success :function(response){
                  var overall =JSON.parse(response);
                   if(overall.status==true){   
                     window.location.reload(true);  


                   }
               }
                    
        });


    });

  });
</script>










