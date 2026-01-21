{!! Form::hidden('episode_ids[]',$episode_id) !!}
{!! Form::hidden('published_id[]',$published_id) !!}
<div class="hidden">
 {!!Form::select('temp_medicine',$drugs) !!}
 {!!Form::select('temp_antibiotic',$antibiotic) !!}
</div> 
@if($problem_layout == 1)
<div class="col-md-12">
        <div class="form-group">
         @php $startdate = (!isset($subepisodeslists->start_date)) ? null : date('d-m-Y', strtotime($subepisodeslists->start_date)) @endphp
		 @php $end_date = (!isset($subepisodeslists->end_date)) ? null : date('d-m-Y', strtotime($subepisodeslists->end_date)) @endphp

		 {!! Form::label('start_date', 'Start Date:') !!}
		 {!! Form::text('start_date[]', $startdate, ['class'=>'form-control datepicker','readonly'=>'true'] ) !!}
		</div>
		<div class="form-group">
		 {!! Form::label('end_date', 'End Date:') !!}
		 {!! Form::text('end_date[]', $end_date, ['class'=>'form-control datepicker','readonly'=>'true'] ) !!}
		</div>
    @foreach($single_column_param as $parameters)	
		<div class="form-group">
		{!! ProblemBaseHelpers::createLabel($parameters); !!}
		@switch($parameters->para_type)
		    @case('type-text')
		        {!! ProblemBaseHelpers::createTextcomponent($parameters, $uniqueId, $param_values); !!}
		        @break
		    @case('type-number')
		        {!! ProblemBaseHelpers::createNumbercomponent($parameters, $uniqueId, $param_values); !!}
		        @break
		    @case('type-decimal')  
		        {!! ProblemBaseHelpers::createDecimalcomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-textarea')
 				{!! ProblemBaseHelpers::createTextareacomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-select')
		        {!! ProblemBaseHelpers::createDropdowncomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-toggle')
 				{!! ProblemBaseHelpers::createTogglecomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-horizontal-selector')
                {!! ProblemBaseHelpers::createHorizontalselector($parameters, $uniqueId, $param_values); !!}
            @break  
            @case('type-check-box')
                {!! ProblemBaseHelpers::createCheckboxcomponent($parameters, $uniqueId, $param_values) !!}
            @break 	
            @case('type-radio')
                {!! ProblemBaseHelpers::createRadiocomponent($parameters, $uniqueId, $param_values) !!}
            @break
            @case('type-label')
                 {!! ProblemBaseHelpers::createHeader($parameters) !!}
            @break
            @case('type-drugs')
                 {!! ProblemBaseHelpers::createDrugset($parameters, $uniqueId, $param_values, $drugs) !!}
            @break 
            @case('type-antibiotic')
                 {!! ProblemBaseHelpers::createAntibioticset($parameters, $uniqueId, $param_values, $antibiotic) !!}
            @break 
    	@endswitch
        
		</div>
	@endforeach 	
</div>
@elseif($problem_layout == 2)
	 <div class="col-md-6">
	 	<div class="form-group">
	 	 @php $startdate = (!isset($subepisodeslists->start_date)) ? null : date('d-m-Y', strtotime($subepisodeslists->start_date)) @endphp
		 {!! Form::label('start_date', 'Start Date:') !!}
		 {!! Form::text('start_date[]', $startdate, ['class'=>'form-control datepicker','readonly'=>'true'] ) !!}
		</div>
    @if(count($left_column_param) > 0)
	 @foreach($left_column_param as $parameters)
	    <div class="form-group">
          @if($parameters->para_type != 'type-label')
	       {!! ProblemBaseHelpers::createLabel($parameters); !!}
	      @endif 

		  @switch($parameters->para_type)
		    @case('type-text')
		        {!! ProblemBaseHelpers::createTextcomponent($parameters, $uniqueId, $param_values); !!}
		        @break
		    @case('type-number')
		        {!! ProblemBaseHelpers::createNumbercomponent($parameters, $uniqueId, $param_values); !!}
		        @break
		    @case('type-decimal')  
		        {!! ProblemBaseHelpers::createDecimalcomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-textarea')
 				{!! ProblemBaseHelpers::createTextareacomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-select')
		        {!! ProblemBaseHelpers::createDropdowncomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-toggle')
 				{!! ProblemBaseHelpers::createTogglecomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-horizontal-selector')
                {!! ProblemBaseHelpers::createHorizontalselector($parameters, $uniqueId, $param_values); !!}
            @break  
            @case('type-check-box')
                {!! ProblemBaseHelpers::createCheckboxcomponent($parameters, $uniqueId, $param_values) !!}
            @break 	
            @case('type-radio')
                {!! ProblemBaseHelpers::createRadiocomponent($parameters, $uniqueId, $param_values) !!}
            @break
            @case('type-label')
                 {!! ProblemBaseHelpers::createHeader($parameters) !!}
            @break
            @case('type-drugs')
                 {!! ProblemBaseHelpers::createDrugset($parameters, $uniqueId, $param_values, $drugs) !!}
            @break 
            @case('type-antibiotic')
                 {!! ProblemBaseHelpers::createAntibioticset($parameters, $uniqueId, $param_values, $antibiotic) !!}
            @break 
    	@endswitch
	    </div>
	 @endforeach
	 </div> 	
	@endif
	 <div class="col-md-6">
	 	<div class="form-group">
	     @php $end_date = (!isset($subepisodeslists->end_date)) ? null : date('d-m-Y', strtotime($subepisodeslists->end_date)) @endphp 		
		 {!! Form::label('end_date', 'End Date:') !!}
		 {!! Form::text('end_date[]', $end_date, ['class'=>'form-control datepicker','readonly'=>'true'] ) !!}
		</div>
   @if(count($right_column_param) > 0)		
	 @foreach($right_column_param as $parameters)
	    <div class="form-group">
	      @if($parameters->para_type != 'type-label')
	       {!! ProblemBaseHelpers::createLabel($parameters); !!}
	      @endif 
		  @switch($parameters->para_type)
		    @case('type-text')
		        {!! ProblemBaseHelpers::createTextcomponent($parameters, $uniqueId, $param_values); !!}
		        @break
		    @case('type-number')
		        {!! ProblemBaseHelpers::createNumbercomponent($parameters, $uniqueId, $param_values); !!}
		        @break
		    @case('type-decimal')  
		        {!! ProblemBaseHelpers::createDecimalcomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-textarea')
 				{!! ProblemBaseHelpers::createTextareacomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-select')
		        {!! ProblemBaseHelpers::createDropdowncomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-toggle')
 				{!! ProblemBaseHelpers::createTogglecomponent($parameters, $uniqueId, $param_values); !!}
		    @break
		    @case('type-horizontal-selector')
                {!! ProblemBaseHelpers::createHorizontalselector($parameters, $uniqueId, $param_values); !!}
            @break  
            @case('type-check-box')
                {!! ProblemBaseHelpers::createCheckboxcomponent($parameters, $uniqueId, $param_values) !!}
            @break 	
            @case('type-radio')
                {!! ProblemBaseHelpers::createRadiocomponent($parameters, $uniqueId, $param_values) !!}
            @break
            @case('type-label')
                 {!! ProblemBaseHelpers::createHeader($parameters) !!}
            @break
            @case('type-drugs')
                 {!! ProblemBaseHelpers::createDrugset($parameters, $uniqueId, $param_values, $drugs) !!}
            @break
            @case('type-antibiotic')
                 {!! ProblemBaseHelpers::createAntibioticset($parameters, $uniqueId, $param_values, $antibiotic) !!}
            @break 
    	@endswitch
	    </div>
	 @endforeach
	@endif
 	</div> 
@endif

