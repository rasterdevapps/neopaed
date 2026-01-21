@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('ProblemsSettings\ProblemsSettingController@index') }}">Problem Settings</a></li>       
        <li class="current"><a>Create</a></li>                                                 
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing problem-parent">
    {!! Form::model(null,['url' => action('ProblemsSettings\ProblemsSettingController@store'),'id'=> 'problem-form']) !!}
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
                        {!! Form::text('problem_name',null,['class'=>'form-control']) !!}
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

            </div>

            <input type="hidden" name="save" value="0">
            <div class="col-md-12 col-sm-12 mtb-20">
                <div class="col-md-2 col-sm-3">
                  <button type="submit" value="1" class="btn btn-primary form-control btn-shadow-special btn-block">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    <span>Save</span>
                </button>
            </div>  
            <div class="col-md-2 col-sm-3">
              <button type="submit" value="2" class="btn btn-info form-control btn-shadow-special btn-block">
                <i class="fa fa-thumbs-up" aria-hidden="true"></i> 
                <span>Publish</span>
            </button>
        </div>
        <div class="col-md-2 col-sm-3">
          <a href="{{ action('ProblemsSettings\ProblemsSettingController@index') }}" class="btn btn-default form-control btn-shadow-special btn-block">
              <i class="fa fa-ban" aria-hidden="true"></i>
              <span>Cancel</span>
          </a>
      </div>
  </div>
</div>
</div>

{!! Form::close(); !!}
@php $problems = ''; @endphp
@include('ProblemsSettings.problem-sidebar',compact('problems'))
<div class="form-property">
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    
    $(document).on('click', '#problem-form button[type="submit"]', function(e){
        e.preventDefault();
        var save_val = $(this).val();
        $('input[name="save"]').val(save_val);
        if ($('#problem-form').valid() === true) {
            $('#problem-form button[type="submit"]').prop('disabled', true);

            $('#problem-form button[type="submit"]').html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
            $('#problem-form').submit();
        }
    });
</script>

@endsection

