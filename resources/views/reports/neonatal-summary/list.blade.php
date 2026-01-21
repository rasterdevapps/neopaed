@extends('app')
@section('content')
    <div class="crumbs bread-crumbs-shadow">
		<ul id="breadcrumbs" class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="{{ url('/') }}">Dashboard</a>
			</li>
			<li class="current">
				<a href="javascript:void(0);">Neonatal Summary</a>
			</li>       
		</ul>
	</div>
	<div class="page-header">
	</div>
	<div class="row row-spacing">
      	<div class="col-md-12">
            <div class="row">
                {!! Form::open(['method'=>'post','url'=>action('Reports\NeonatalSummaryController@neonatal_summary')]) !!}
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('BabyId','Select Baby:') !!}
                        {!! Form::Select('BabyId',$baby_list,null,['class'=>'select2-select-00 input-fields-shadow full-width-fix']) !!}
                    </div>
				</div>
                <div class="col-md-12">
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <button type="submit" class="btn btn-success  save-button-shadow  submitbtn form-control">
                            <i class="fa fa-forward"></i> 
                            <span>{!! $SubmitButtonText !!}</span>
                        </button>
                    </div>
                </div>                           
            </div>
		</div> 
    </div>	
@endsection			
