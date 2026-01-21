@extends('app')

@section('content')
<div class="temp-container">
	<div class="temp-row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Newborn Examination <a class="pull-right" href="/newborn">Go Back</a></div>

				<div class="panel-body">
                       {!! Form::open(['url' => 'newborn']) !!}
  <!-- Nav tabs -->
                <div role="tabpanel">
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#basicform" aria-controls="basicform" role="tab" data-toggle="tab">Basic Details</a></li>
    <li role="presentation"><a href="#vitals" aria-controls="vitals" role="tab" data-toggle="tab">VITALS</a></li>
    <li role="presentation"><a href="#gpe" aria-controls="gpe" role="tab" data-toggle="tab">GPE</a></li>    
    <li role="presentation"><a href="#cvs" aria-controls="cvs" role="tab" data-toggle="tab">CVS</a></li>    
    <li role="presentation"><a href="#rs" aria-controls="rs" role="tab" data-toggle="tab">RS</a></li>    
    <li role="presentation"><a href="#abdomen" aria-controls="abdomen" role="tab" data-toggle="tab">ABDOMEN</a></li>    
    <li role="presentation"><a href="#cns" aria-controls="cns" role="tab" data-toggle="tab">CNS</a></li>                    
  </ul>
  <!-- Tab panes -->
 <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="basicform">
						<div class="col-md-5 ">
                       		<div class="form-group">
                            	{!! Form::label('TestDate','Test Date:') !!}
                                {!! Form::text('TestDate',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('BabyId','Select Baby:') !!}
                                {!! Form::Select('BabyId',$babies,null,['class'=>'form-control']) !!}
                            </div>

                            
                         </div>
                         <div class="col-md-offset-1 col-md-5">
                       		<div class="form-group">
                            	{!! Form::label('TestTime','Test Time:') !!}
                                {!! Form::text('TestTime',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('SeenBy','Seen By:') !!}
                                {!! Form::select('SeenBy',['RK'=>'RK','PK'=>'PK'],null,['class'=>'form-control']) !!}
                            </div>    
                         </div>
 	</div>
<div role="tabpanel" class="tab-pane" id="vitals">

                         <div class=" col-md-5">

                       		<div class="form-group">
                            	{!! Form::label('HR','HR in bpm:') !!}
                                {!! Form::text('HR',null,['class'=>'form-control']) !!}
                            </div>                                                        
                       		                                                       
                       		<div class="form-group">
                            	{!! Form::label('RR','RR:') !!}
                                {!! Form::text('RR',null,['class'=>'form-control']) !!}
                            </div>               

                       		<div class="form-group">
                            	{!! Form::label('CFT','CFT:') !!}
                                {!! Form::text('CFT',null,['class'=>'form-control']) !!}
                            </div>                            
                       		<div class="form-group">
                            	{!! Form::label('TemperatureF','Temperature F:') !!}
                                {!! Form::text('TemperatureF',null,['class'=>'form-control']) !!}
                            </div>              
	                        
                      </div>
                       <div class="col-md-offset-1 col-md-5">                             
                      		<div class="form-group">
                            	{!! Form::label('CentralPulses','Central Pulses:') !!}
                                {!! Form::select('SeenBy',['Well Palpable'=>'Well Palpable','Bounding'=>'Bounding','feeble'=>'feeble'],null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('PeripheralPulses','Peripheral Pulses:') !!}
                                {!! Form::text('PeripheralPulses',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('SpO2','SpO2:') !!}
                                {!! Form::text('SpO2',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('Colour','Colour:') !!}
                                {!! Form::text('Colour',null,['class'=>'form-control']) !!}
                            </div>    

						 </div>    	
	</div>
<div role="tabpanel" class="tab-pane" id="gpe">

                         <div class=" col-md-5">

                       		<div class="form-group">
                            	{!! Form::label('Pallor','Pallor:') !!}
                                {!! Form::select('Pallor',['Present'=>'Present','Absent'=>'Absent'],'Absent',['class'=>'form-control']) !!} 
                            </div>                                                        
                       		                                                       
                       		<div class="form-group">
                            	{!! Form::label('Scalp','Scalp:') !!}
                                {!! Form::text('Scalp',null,['class'=>'form-control']) !!}
                            </div>               

                       		<div class="form-group">
                            	{!! Form::label('Eyes','Eyes:') !!}
                                {!! Form::text('Eyes',null,['class'=>'form-control']) !!}
                            </div>                            
                       		<div class="form-group">
                            	{!! Form::label('Ears','Ears:') !!}
                                {!! Form::text('Ears',null,['class'=>'form-control']) !!}
                            </div>                                           
                       		<div class="form-group">
                            	{!! Form::label('Nose','Nose:') !!}
                                {!! Form::text('Nose',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('Nostrils','Nostrils:') !!}
                                {!! Form::text('Nostrils',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('Lips','Lips:') !!}
                                {!! Form::text('Lips',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('Palate','Palate:') !!}
                                {!! Form::text('Palate',null,['class'=>'form-control']) !!}
                            </div>    
                       		<div class="form-group">
                            	{!! Form::label('Neck','Neck:') !!}
                                {!! Form::text('Neck',null,['class'=>'form-control']) !!}
                            </div>    
                       		<div class="form-group">
                            	{!! Form::label('Nipples','Nipples:') !!}
                                {!! Form::text('Nipples',null,['class'=>'form-control']) !!}
                            </div>    
                       		<div class="form-group">
                            	{!! Form::label('Esophagus','Esophagus:') !!}
                                {!! Form::text('Esophagus',null,['class'=>'form-control']) !!}
                            </div>    
                       		<div class="form-group">
                            	{!! Form::label('Umbilicus','Umbilicus:') !!}
                                {!! Form::text('Umbilicus',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                            	{!! Form::label('UmbilicalCord','UmbilicalCord:') !!}
                                {!! Form::text('UmbilicalCord',null,['class'=>'form-control']) !!}
                            </div>     
                            <div class="form-group">
                            	{!! Form::label('AnteriorFontanelle','Anterior Fontanelle:') !!}
                                {!! Form::text('AnteriorFontanelle',null,['class'=>'form-control']) !!}
                            </div>
                            
						 </div>
                         <div class="col-md-offset-1 col-md-5">
                       		<div class="form-group">
                            	{!! Form::label('Jaundice','Jaundice:') !!}
                                {!! Form::text('Jaundice',null,['class'=>'form-control']) !!}
                            </div>
							<div class="form-group">
                            	{!! Form::label('HernialOrifices','Hernial Orifices:') !!}
                                {!! Form::text('HernialOrifices',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                            	{!! Form::label('FemoralPulses','Femoral Pulses:') !!}
                                {!! Form::text('FemoralPulses',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                            	{!! Form::label('Genitalia','Genitalia:') !!}
                                {!! Form::text('Genitalia',null,['class'=>'form-control']) !!}
                            </div>  
                       		<div class="form-group">
                            	{!! Form::label('Hips','Hips:') !!}
                                {!! Form::text('Hips',null,['class'=>'form-control']) !!}
                            </div>                            

                       		<div class="form-group">
                            	{!! Form::label('Anus','Anus:') !!}
                                {!! Form::text('Anus',null,['class'=>'form-control']) !!}
                            </div>    
                       		<div class="form-group">
                            	{!! Form::label('Spine','Spine:') !!}
                                {!! Form::text('Spine',null,['class'=>'form-control']) !!}
                            </div>    
                       		<div class="form-group">
                            	{!! Form::label('RtUL','Rt UL:') !!}
                                {!! Form::text('RtUL',null,['class'=>'form-control']) !!}
                            </div>    
                       		<div class="form-group">
                            	{!! Form::label('RtLL','Rt LL:') !!}
                                {!! Form::text('RtUL',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group">
                            	{!! Form::label('LtUL','Lt UL:') !!}
                                {!! Form::text('LtUL',null,['class'=>'form-control']) !!}
                            </div>  
							<div class="form-group">
                            	{!! Form::label('LtLL','Lt LL:') !!}
                                {!! Form::text('LtLL',null,['class'=>'form-control']) !!}
                            </div>  
							<div class="form-group">
                            	{!! Form::label('Skin','Skin:') !!}
                                {!! Form::text('Skin',null,['class'=>'form-control']) !!}
                            </div>                              
							<div class="form-group">
                            	{!! Form::label('Hairs','Hairs:') !!}
                                {!! Form::text('Hairs',null,['class'=>'form-control']) !!}
                            </div>      
							<div class="form-group">
                            	{!! Form::label('AnyOtherAbnormality','Any Other Abnormality:') !!}
                                {!! Form::textarea('AnyOtherAbnormality',null,['class'=>'form-control']) !!}
                            </div>                                                          

				 </div>    	
	</div>
    <div role="tabpanel" class="tab-pane" id="cvs">

                         <div class=" col-md-5">

                       		<div class="form-group">
                            	{!! Form::label('PrecordialActivity','Precordial Activity:') !!}
                                {!! Form::select('PrecordialActivity',['Present'=>'Present','Absent'=>'Absent'],'Absent',['class'=>'form-control']) !!}                                </div>                                                        
                       		                                                       
                       		<div class="form-group">
                            	{!! Form::label('ApicalImpulse','Apical Impulse:') !!}
                                {!! Form::select('ApicalImpulse',['Normal'=>'Normal','Right Side'=>'Right Side'],'Normal',['class'=>'form-control']) !!}
                            </div>               

                       		<div class="form-group">
                            	{!! Form::label('BoundingPulses','Bounding Pulses:') !!}
                                 {!! Form::select('BoundingPulses',['Present'=>'Present','Absent'=>'Absent'],'Absent',['class'=>'form-control']) !!} 
                            </div>                            
 

                            
                            
						 </div>    	
                         <div class="col-md-offset-1 col-md-5">
                      		<div class="form-group">
                            	{!! Form::label('S1S2','S1S2:') !!}
                                {!! Form::select('S1S2',['Normal'=>'Normal','Abnormal'=>'Abnormal'],'Normal',['class'=>'form-control']) !!}
                            </div>                                           
                       		<div class="form-group">
                            	{!! Form::label('Murmur','Murmur:') !!}
                                 {!! Form::select('Murmur',['Present'=>'Present','Absent'=>'Absent'],'Absent',['class'=>'form-control']) !!} 
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('CharacterofMurmur','Character of Murmur:') !!}
                                {!! Form::text('CharacterofMurmur',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('SiteofMurmur','Site of Murmur:') !!}
                                {!! Form::text('SiteofMurmur',null,['class'=>'form-control']) !!}
                            </div>                         
                         </div>
	</div>    
<div role="tabpanel" class="tab-pane" id="rs">

                         <div class=" col-md-5">

                       		<div class="form-group">
                            	{!! Form::label('ChestMovement','Chest Movement:') !!}
                                {!! Form::select('ChestMovement',['Symmetrical','Asymmetrical'],'Symmetrical',['class'=>'form-control']) !!}
                                </div>                                                        
                       		                                                       
                       		<div class="form-group">
                            	{!! Form::label('BreathSounds','Breath Sounds:') !!}
                                {!! Form::select('BreathSounds',['Normal Vesicular','Abnormal'],'Normal Vesicular',['class'=>'form-control']) !!}
                            </div>               

                       		<div class="form-group">
                            	{!! Form::label('AirEntry','Air Entry:') !!}
                                {!! Form::text('AirEntry',null,['class'=>'form-control']) !!}
                            </div>  
                                                               
                            </div>
                            <div class="col-md-offset-1 col-md-5">                  
                       		<div class="form-group">
                            	{!! Form::label('AddedSounds','Added Sounds:') !!}
                                {!! Form::select('AddedSounds',['Present','Absent'],'Absent',['class'=>'form-control']) !!}
                            </div>                                           
                       		<div class="form-group">
                            	{!! Form::label('CharacterOfAddedSounds','Character Of Added Sounds:') !!}
                                {!! Form::text('CharacterOfAddedSounds',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('SiteofAddedSounds','SiteofAddedSounds:') !!}
                                {!! Form::text('SiteofAddedSounds',null,['class'=>'form-control']) !!}
                            </div>

						 </div>    	
	</div>
<div role="tabpanel" class="tab-pane" id="abdomen">

                         <div class=" col-md-5">

                       		<div class="form-group">
                            	{!! Form::label('AbdomenShape','Abdomen Shape:') !!}
                                {!! Form::text('AbdomenShape',null,['class'=>'form-control']) !!}
                            </div>                                                        
                       		                                                       
                       		<div class="form-group">
                            	{!! Form::label('Hepatomegaly','Hepatomegaly:') !!}
                                {!! Form::select('Hepatomegaly',['Present','Absent'],'Absent',['class'=>'form-control']) !!}
                            </div>               

                       		<div class="form-group">
                            	{!! Form::label('LiverSpan','Liver Span:') !!}
                                {!! Form::text('LiverSpan',null,['class'=>'form-control']) !!}
                            </div>                            
                       		<div class="form-group">
                            	{!! Form::label('Splenomegaly','Splenomegaly:') !!}
                                {!! Form::select('Splenomegaly',['Present','Absent'],'Absent',['class'=>'form-control']) !!}
                            </div>  
                                                           
                      </div>
                      <div class="col-md-offset-1 col-md-5">                                      
                       		<div class="form-group">
                            	{!! Form::label('SpleenSpan','Spleen Span:') !!}
                                {!! Form::text('SpleenSpan',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('Flanks','Flanks:') !!}
                                {!! Form::text('Flanks',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('AnyOtherMass','Any Other Mass:') !!}
                                {!! Form::textarea('AnyOtherMass',null,['class'=>'form-control']) !!}
                            </div>

						 </div>    	
                </div>        
                <div role="tabpanel" class="tab-pane" id="cns">
                         <div class=" col-md-5">
                       		<div class="form-group">
                            	{!! Form::label('LevelOfConsciousness','Level Of Consciousness:') !!}
                                {!! Form::text('LevelOfConsciousness',null,['class'=>'form-control']) !!}
                            </div>                                                        
                       		                                                       
                       		<div class="form-group">
                            	{!! Form::label('Seizures','Seizures:') !!}
                                {!! Form::text('Seizures',null,['class'=>'form-control']) !!}
                            </div>               

                       		<div class="form-group">
                            	{!! Form::label('TypeofSeizure','Type of Seizure:') !!}
                                {!! Form::text('TypeofSeizure',null,['class'=>'form-control']) !!}
                            </div>                            
                       		<div class="form-group">
                            	{!! Form::label('GeneralBodyMovements','General Body Movements:') !!}
                                {!! Form::text('GeneralBodyMovements',null,['class'=>'form-control']) !!}
                            </div>        
			                                                  
                      </div>
                      <div class="col-md-offset-1 col-md-5">                             
                       		<div class="form-group">
                            	{!! Form::label('SpontaneousActivity','Spontaneous Activity:') !!}
                                {!! Form::text('SpontaneousActivity',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('Cry','Cry:') !!}
                                {!! Form::text('Cry',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('Tone','Tone:') !!}
                                {!! Form::text('Tone',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('NeonatalReflexes','Neonatal Reflexes:') !!}
                                {!! Form::text('NeonatalReflexes',null,['class'=>'form-control']) !!}
                            </div>    

						 </div>    	
	</div>  
      
  </div>
  <div class="button-row">
         <div class="col-md-3">
        {!! Form::submit($SubmitButtonText,['class' => 'btn btn-primary form-control']) !!}
        </div>
        <div class="col-md-3">
          <a href="/newborn" class="btn btn-default form-control">Cancel</a>
       </div>
   </div>   
</div>

                       {!! Form::close() !!}
                      @include('errors.list')
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$( "form" ).sisyphus({  customKeySuffix: "nb", locationBased: true });
</script>
@endsection