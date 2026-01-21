@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
@php $hide='true'; @endphp
{{ Session::put('daycare-create-slug','3') }}
{{ Session::put('daycare-baby-id',$babyId) }}
{{ Session::put('daycare-baby-admissionid',$admission_id) }}
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{url('/')}}">{{ Lang::get('home.daycare_list_dashboard') }}</a></li>
        <li><a href="{{ action('Admission\DaycareController@index') }}">{{ Lang::get('home.daycare_list_daycare')}}</a></li>
        <li><a href="{{ action('Admission\DaycareController@daycareBabysubList',SiteHelpers::encrypt_id($babyId))}}">
            @if(!empty($babyName)) 
            {{ Lang::get('home.daycare_list_history') }} {{ $babyName  }}  {{ $bmrno  or  '' }}
            @else 
            {{ Lang::get('home.daycare_list_baby_history') }} 
            @endif
        </a>
    </li>
    <li><a href="javascript:void(0);">{{ $episodes }}</a></li>
</ul>
</ul>
<div class="pull-right">
    @php
    echo \SiteHelpers::menuList($bmrno, $admission_id, 'daycare_list');
    @endphp
</div>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>{{ Lang::get('home.daycare_list_daycare')}}</h4>
                @if(in_array('NICU_DAY',$write_permission))
                @if(isset($flow_wise_register) && $flow_wise_register == 'from-dashboard')
                <a href="{{ url('daycare-admission/'.SiteHelpers::encrypt_id($admission_id.'-'.$babyId)) }}?flow=from-dashboard" title="Create New" class="btn btn-info create-btn-spacing btn-basic-shadow pull-right"><i class="fa fa-plus "></i> <span>{{ Lang::get('home.daycare_list_create') }}</span></a>  
                @else
                <a href="{{ url('daycare-admission/'.SiteHelpers::encrypt_id($admission_id.'-'.$babyId)) }}" title="Create New" class="btn btn-info create-btn-spacing btn-basic-shadow pull-right"><i class="fa fa-plus "></i> <span>{{ Lang::get('home.daycare_list_create') }}</span></a>  
                @endif                              
                @endif                              
            </div>
            <div class="widget-content inherittable">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row"></div>
                    <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
                        <thead>
                            <tr>
                                <th>{{ Lang::get('home.daycare_list_sno') }}</th>
                                <th>{{ Lang::get('home.daycare_list_days')}}</th>
                                <th>{{ Lang::get('home.daycare_list_date')}}</th>
                                @if($hide=='true')
                                <th  class="hidden-xs">
                                    Print 
                                </th>
                                <th  class="hidden-xs">
                                    Reassessment Print 
                                </th>
                                <th  class="hidden-xs hide">
                                    Edited Print
                                </th>
                                @if(in_array('NICU_DAY',$delete_permission))
                                <th class="center-align-phone hidden-xs">
                                    {{ Lang::get('home.daycare_list_delete')}}
                                </th>
                                @endif
                                @endif
                                <th  class="hidden-xs">
                                    Status
                                </th>
                            <!-- <th>
                                Reassessment Sheet
                            </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = count($results); @endphp
                        @foreach($results as $res_key => $result)
                        <tr>
                            <td>{{ $res_key + 1 }}</td>
                            <td>
                                @if(isset($flow_wise_register) && $flow_wise_register == 'from-dashboard')
                                <a class="pull-left input-width-small icon @if(!in_array('NICU_DAY',$write_permission)) permission-denied @endif" href=" @if(in_array('NICU_DAY',$write_permission)) {{ action('Admission\DaycareController@edit', SiteHelpers::encrypt_id($result->DayId)).'?flow=from-dashboard' }} @else javascript:void(0); @endif">
                                    @else
                                    <a class="pull-left input-width-small icon @if(!in_array('NICU_DAY',$write_permission)) permission-denied @endif" href=" @if(in_array('NICU_DAY',$write_permission)) {{ action('Admission\DaycareController@edit', SiteHelpers::encrypt_id($result->DayId)) }} @else javascript:void(0); @endif">
                                        @endif
                                        Day {{ $i }}
                                    </a>
                                    <span class="pull-left">
                                        @if (isset($file_list[$result->DayId]))
                                            @foreach($file_list[$result->DayId] as $type => $count)
                                                @include('registration.media_list')
                                            @endforeach
                                        @endif
                                    </span> 
                                </td>
                                <td>{{ date('d-m-Y', strtotime($result->DayDate)) }}</td>
                                @if($hide=='true')                      
                                <td  class="center-align-phone hidden-xs">
                                    <a class="btn btn-warning btn-view bs-tooltip" href="{{ action('Admission\DaycareController@printData',SiteHelpers::encrypt_id($result->DayId)) }}" title="Generated Print">
                                        <i class="fa fa-print"></i> 
                                    </a>
                                </td>                 
                                <td  class="center-align-phone hidden-xs">
                                    <a class="btn btn-warning btn-view bs-tooltip" href="{{ action('Admission\DaycareController@reassessmentPrintData',SiteHelpers::encrypt_id($result->DayId)) }}" title="Generated Print">
                                        <i class="fa fa-print"></i> 
                                    </a>
                                </td>
                                @if(in_array('NICU_DAY',$delete_permission))
                                <td  class="center-align-phone hidden-xs">
                                    <a class="btn btn-danger btn-view mr-10" href="javascript:void(0);" onclick="DeleteData({{ $result->DayId }})">
                                        <i class="fa fa-trash"></i> 
                                    </a>
                                </td>
                                @endif 
                                <td  class="center-align-phone hidden-xs hide">
                                    @if ($result->edited)
                                    <a class="btn btn-default btn-view bs-tooltip open-doc-editor" href="{{ action('Admission\DaycareController@getAbbreviatedsummaryShow',$result->DayId) }}" title="Final Print">
                                        <i class="fa fa-file-word-o"></i> 
                                    </a>         
                                    @else
                                    -
                                    @endif
                                </td>
                                @endif     
                                @php
                                $daycare_started = '';
                                $daycare_partial = '';
                                $daycare_completed = '';
                                @endphp 
                                @if ($result->form_status == 0)
                                @php $daycare_started = 'active'; @endphp
                                @elseif ($result->form_status == 1)
                                @php $daycare_partial = 'active'; @endphp
                                @else
                                @php $daycare_completed = 'active'; @endphp
                                @endif 
                                <td  class="center-align-phone hidden-xs">
                                    <span class="status-container">
                                        <strong class="not-started {{ $daycare_started }}"></strong>
                                        <strong class="partial {{ $daycare_partial }}"></strong>
                                        <strong class="completed {{ $daycare_completed }}"></strong>
                                    </span>
                                </td> 
                            <!-- <td>
                                <a class="btn btn-info btn-view bs-tooltip" href="{{ action('Admission\DaycareController@reassessmentCreate',['day_id'=>SiteHelpers::encrypt_id($result->DayId)]) }}" title="Create Reassessment">
                                      <i class="fa fa-plus"></i> 
                                    </a>
                                <a class="btn btn-primary btn-view bs-tooltip" href="{{ action('Admission\DaycareController@printData',$result->DayId) }}" title="Edit Reassessment">
                                      <i class="fa fa-edit"></i> 
                                    </a>
                                <a class="btn btn-warning btn-view bs-tooltip" href="{{ action('Admission\DaycareController@printData',$result->DayId) }}" title="Print">
                                      <i class="fa fa-print"></i> 
                                    </a>
                                </td> -->
                            </tr>
                            @php $i--; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <!-- /Page Content -->
<!--
    DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK 
-->   
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}        
@endsection
@section('scripts')
<script type="text/javascript">
    function DeleteData(id){
      bootbox.confirm("Are you sure?",function(confirmed){
          if(confirmed){
              $("#DeleteForm").attr('action',"{{ action('Admission\DaycareController@index') }}/"+id);
              $("#DeleteForm").submit();
          }
      });
  }

  $('.sorting_by').click(function(e){
    e.preventDefault();
    $('#sortby').val($(this).data('field'));
       if($('#sortorder').val()=='desc'){
          $('#sortorder').val('asc');
}else{
  $('#sortorder').val('desc');
}
$('#limit-form').submit();

});

$('.sort_with_page').click(function(e){
  e.preventDefault();
  var sorting_param=$('#limit-form').serialize();
      var link =$(this).attr('href');
          window.location=link+'&'+sorting_param;


      });
      $(document).ready(function(){

        var dataTableresponseive = ['.dataTables_header .col-md-6','.dataTables_footer .col-md-6'];

        $.each(dataTableresponseive,function(dataTableclassindex,dataTableclassvalue){

            $(dataTableclassvalue).each(function(dataTablechildindex,dataTablechildvalue){
                if(dataTablechildindex == 0){
                    $(this).addClass('col-xs-4');
                }
                if(dataTablechildindex == 1){
                    $(this).addClass('col-xs-8');
                }
            });

        });

    });
</script>
@endsection
