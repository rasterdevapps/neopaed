@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('ProblemsSettings\ProblemsSettingController@index') }}">Problem Settings</a></li>
        <li class="current"><a>Edit</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing problem-parent">
    {!! Form::model($problems,['method' => 'PATCH','url' => action('ProblemsSettings\ProblemsSettingController@update',$problems->problem_id),'id'=> 'problem-form']) !!}
    <div class="col-md-8 col-sm-8 widget box" style="display: inline-block;">
        <div class="widget-header">
            <h4><i class="fa fa-reorder"></i> Problem</h4>
        </div>
        <div class="widget-content row mx-0">
            <div class="hidden">
                <input type="text" name="formpropertyuri" value="{{ action('ProblemsSettings\ProblemsSettingController@getFromproperty') }}">
                <input type="text" name="dropoptionuri" value="{{ action('ProblemsSettings\ProblemsSettingController@getDropboxoption') }}">
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="col-md-12 p-0">
                    <div class="form-group">
                        {!! Form::label('problem_name','Name:') !!}
                        {!! Form::text('problem_name',null,['class'=>'form-control input-shadow-special']) !!}
                    </div>
                    <label class="error">{!! $errors->first('problem_name') !!}</label>
                </div>
                {!! Form::hidden('problem_layout',null,['class'=>'form-control']) !!}
            </div>
            <div class="col-md-12 col-sm-12 master-problem-fields-header">
                <div class="form-group">
                    <b><i class="fa fa-reorder"></i> {!! Form::label('problem_fields','Fields',['class'=>'problem-title']) !!}</b>                    
                </div>
            </div>
            <div class="col-md-12 col-sm-12 master-problem-fields tab-label-shadow">
                @if($problems->problem_layout == 1)
                <section class="col-md-9 single-column-problem" id="single-column-problem" data-position="problem-fields-center">
                    @if(count($problems_list) > 0)
                    @php $i = 1; @endphp
                    @foreach($problems_list as $fieldsPropertice)
                    {!! FormHelpers::constructGroup($fieldsPropertice, $i, $drugs, $antibiotic) !!}
                    @php $i++;  @endphp
                    @endforeach 
                    @endif
                </section>
                @elseif($problems->problem_layout == 2)
                <section class="col-md-5 problem-fields-left" id="box-left" data-position="problem-fields-left" >
                    @php $i = 1; @endphp
                    @if(count($problems_list->where('para_position','problem-fields-left')) > 0) 
                    @foreach($problems_list->where('para_position','problem-fields-left') as $lists)
                    {!! FormHelpers::constructGroup($lists, $i, $drugs, $antibiotic) !!}
                    @php $i++; @endphp
                    @endforeach
                    @else
                    <h3 class="head-label-left">Please add fields for right side.</h3>
                    @endif    
                </section>
                <section class="col-md-5 problem-fields-right" id="box-right" data-position="problem-fields-right">
                    @if(count($problems_list->where('para_position','problem-fields-right')) > 0) 
                    @foreach($problems_list->where('para_position','problem-fields-right') as $lists)
                    {!! FormHelpers::constructGroup($lists, $i, $drugs, $antibiotic) !!}
                    @php $i++; @endphp
                    @endforeach
                    @else
                    <h3 class="head-label-right">Please add fields for right side.</h3>
                    @endif    
                </section>
                @endif
            </div>
            <div class="col-md-12 col-sm-12 mtb-20 plr-0">
                <div class="col-md-2 col-sm-3">
                    <button type="submit" value="1" name="save" class="btn btn-primary form-control btn-shadow-special btn-block">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                        <span>Update</span>
                    </button>
                </div>
                <div class="col-md-2 col-sm-3">
                    <button type="submit" value="2" name="save" class="btn btn-info form-control btn-shadow-special btn-block">
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i> 
                        <span>Publish</span>
                    </button>
                </div>
                <div class="col-md-2 col-sm-3">  
                    <button type="submit" value="3" name="save" class="btn btn-info form-control btn-shadow-special btn-block">
                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                        <span>Unpublish</span>
                    </button>
                </div>
                <div class="col-md-2 col-sm-3">
                    <a href="{{ action('ProblemsSettings\ProblemsSettingController@index') }}" class="btn btn-primary form-control btn-shadow-special btn-block">
                        <i class="fa fa-ban" aria-hidden="true"></i>
                        <span>Cancel</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
{!! Form::close(); !!}     
@include('ProblemsSettings.problem-sidebar',compact('problems'))
<div class="form-property"></div>
@php $horizontalSelector = $problems_list->where('para_type','type-horizontal-selector')->pluck('para_name')->toArray(); @endphp
@endsection
@section('scripts')
<script type="text/javascript">
    @foreach($horizontalSelector as $selectors)
    
    buildSelector('{{"$selectors"}}');
    
    @endforeach
    
    
</script>
@endsection