@extends('app')
@section('content')
</style>
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('interfacelog\InterfaceMachineController@index') }}">Interface Machine</a>
		</li>
		<li class="current">
			<a href="javascript::void(0);">Show</a>
		</li>                                         
	</ul>
</div>
<div class="row-spacing">
    <div class="col-md-12 tab-view-shadow p-0 pt-20">
    	<div class="col-md-12 form-group">
    		{{ Form::label('received','Received') }}
    		
    		{{ Form::textarea('received',($machinedata->received),['class'=>'form-control','rows'=>25, 'readonly'=>true]) }}</td>
    	</div>
    	<div class="col-md-12 plr-0">
    		<div class="col-md-6 col-sm-6 form-group">
	    		{{ Form::label('receivedtime','Received Time') }}
	    		{{ Form::text('receivedtime',date('h:i a', strtotime($machinedata->received_time)),['class'=>'form-control', 'readonly'=>true]) }}</td>
	    	</div>
	    	<div class="col-md-6 col-sm-6 form-group">
	    		{{ Form::label('isparsed','Is Parsed') }}
	    		@php $machinedata->is_parsed  = $machinedata->is_parsed == 1 ? 'Yes' : 'No' @endphp
	    		{{ Form::text('isparsed',$machinedata->is_parsed,['class'=>'form-control', 'readonly'=>true]) }}</td>
	    	</div>
	    	<div class="col-md-6 col-sm-6 form-group">
	    		{{ Form::label('receivedip','Received Ip') }}
	    		{{ Form::text('receivedip',$machinedata->received_ip,['class'=>'form-control', 'readonly'=>true]) }}</td>
	    	</div>
	    	<div class="col-md-6 col-sm-6 form-group">
	    		{{ Form::label('receiveddate','Received Date') }}
	    		{{ Form::text('receiveddate',date( 'd-m-Y',strtotime($machinedata->received_date)),['class'=>'form-control', 'readonly'=>true]) }}</td>
	    	</div>
    	</div>
    	<div class="col-md-12 text-center pb-20">
    	  <a href="{{ action('interfacelog\InterfaceMachineController@index') }}" class="btn save-button-shadow btn-default">
    	  	<i class="fa fa-remove"></i>
    	  	<span>Close</span>
    	  </a>
        </div>
    </div>
   
</div>
@endsection
