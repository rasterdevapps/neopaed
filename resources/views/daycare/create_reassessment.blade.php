@extends('app')
@section('content')
<style type="text/css">
  .btn-view {
    margin-top: 6px;
  }
  .reassessment-add {
    margin-left: -15px;
    margin-right: -15px;
    z-index: auto;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
   }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
  <ul id="breadcrumbs" class="breadcrumb">
    <li><i class="icon-home"></i><a href="{{url('/')}}">{{ Lang::get('home.daycare_list_dashboard') }}</a></li>
    <li><a href="{{ action('Admission\DaycareController@index') }}">{{ Lang::get('home.daycare_list_daycare')}}</a></li>  
    <li><a href="{{ action('Admission\DaycareController@daycareBabysubList',SiteHelpers::encrypt_id($day_id))}}">
      @if(!empty($babyName)) 
      {{ Lang::get('home.daycare_list_history') }} {{ $babyName  }}  {{ $bmrno  or  '' }}
      @else 
      {{ Lang::get('home.daycare_list_baby_history') }} 
      @endif
    </a>
  </li> 
</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
  <div class="col-md-12">
    {!! Form::open(['url' => action('Admission\DaycareController@reassessmentSheetStore'),'id'=> 'checkform']) !!}
    {!! Form::hidden('Id',null,['class'=>'form-control','id'=>'Id']) !!}
  <div class="tab-content tab-view-shadow col-md-12" style="display: inline-grid;">
    @include('daycare.daycare_reassessment',['SubmitButtonText'=>'Save'])

    {!! Form::close() !!}
  <div class="col-md-12 mtb-20">
    
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" onclick="$('#print_flag').val('2'); $(form).submit();" class="btn  btn-block save-button-shadow btn-primary form-control"><i class="fa fa-floppy-o"></i>
                        <span>Update</span>
                    </button>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-block btn-info  save-button-shadow form-control"
                    onclick="$('#print_flag').val('1'); $(form).submit();"><i class="fa fa-print"></i>
                    <span>Print</span>
                </button>
  </div>
  </div> 
  </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->
@endsection