@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<style type="text/css">
  .btn.active {
    background-color: #D9EDF7;
    color: black;
    font-weight: bold;
}
.toggle-on, .toggle-on:hover {
    background: #DFF0D8;
    color: black;
    font-weight: bold;
}
</style>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }} ">{{ Lang::get('home.nicu_summary_dashboard') }}</a>
        </li>
        <li class="current">
            <a href="{{ action('Reports\NicuDischargeController@discharge_main_list') }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif">@if(isset($summary_type) && $summary_type == 'interim') Interim Summary @else {{ Lang::get('home.nicu_summary_summary') }} @endif</a>
        </li>
    </ul>
    <ul class="pull-right nicu-summary-list discharge-color-code mr-15">
        <li>
            <a href="{{ action('Reports\NicuDischargeController@DischargeSummarySearch') }}" class="btn btn-basic-shadow btn-info hidden-xs hidden-sm mtb-3 search-btn">
                <i class="fa fa-search"></i> 
                <span>{{ Lang::get('home.nicu_summry_advanced_search') }}</span>
            </a>
        </li>
        <li><span class="info-tick info"></span> <b class="mb-2"> Inpatient</b></li>
        <li><span class="tick success"></span>  <b class="mb-2"> Discharged or Deceased</b></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>@if(isset($summary_type) && $summary_type == 'interim') Interim Summary @else {{ Lang::get('home.nicu_summary_summary') }} @endif</h4>
                @include('admission_filter')
                <a href="{{ action('Reports\NicuDischargeController@DischargeSummarySearch') }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif" class="btn btn-basic-shadow btn-info visible-xs visible-sm pull-right mtb-3"><span>{{ Lang::get('home.nicu_summry_advanced_search') }}</span></a>
            </div>
            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-xs-4 col-sm-6 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                        @if(isset($summary_type) && $summary_type == 'discharged') 
                                        @php($url = action('Reports\NicuDischargeController@discharge_main_list').'/discharged')
                                        @else 
                                        @php($url = action('Reports\NicuDischargeController@discharge_main_list')) 
                                        @endif
                                        {!! Form::open(['url' => $url, 'method' => 'get', 'id' => 'limit-form']) !!}
                                        <select name="limit"  size="1" aria-controls="data-list">
                                            <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                                            <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                                            <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                                            <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                                            <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                        </select><span class="hidden-xs">{{ Lang::get('home.nicu_summary_records') }}</span>
                                        {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                        {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                                        {!! Form::close() !!}
                                    </label>
                                </div>
                            </div>
                            @if(isset($summary_type) && $summary_type == 'discharged') 
                            @php($search_url = action('Reports\NicuDischargeController@discharge_main_list').'/discharged')
                            @else 
                            @php($search_url = action('Reports\NicuDischargeController@discharge_main_list')) 
                            @endif
                                    {!! Form::open(['url' => $search_url, 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                            <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                    <!-- <div class="col-md-4 col-xs-6" style="overflow-x: hidden;">                    
                                        <input id="admission_status" data-size="small" data-off="Inpatient" data-on="Discharged" data-width="140" data-toggle="toggle" class="form-control switch-input" type="checkbox" @if(isset($summary_type) && $summary_type == 'discharged') checked @endif value="1">
                                    </div> -->
                                    <div class="input-group">
                                        <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                        <input type="text" aria-controls="data-list" class="form-control" name="search_txt"  value="{!! @$search['search_txt'] !!}" placeholder="{{ Lang::get('home.nicu_summary_search') }}">
                                        <a href="{{ $url }}" class="input-group-addon" id="search-reset"><i class="glyphicon glyphicon-remove"></i></a>
                                    </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th>{{ Lang::get('home.nicu_summary_sno')}}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'baby.BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('baby.BabyName') }}">{{ Lang::get('home.nicu_summary_baby_name') }}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'baby.BMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('baby.BMrNo') }}" data-hide="phone,tablet">{{ Lang::get('home.mrn') }}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'DOB') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('DOB') }}">{{ Lang::get('home.nicu_summary_dob') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($results))
                        @for ($i = 0; $i <  @count($results); $i++)
                        <tr class="{{ $results[$i]->rowcolor }}">
                            <td>{{ $i+1 }}</td>
                            <td>
                                @if (isset($results[$i]->NeonatalId))
                                <a href="{{ url('nicu-discharge-sub-list/'.SiteHelpers::encrypt_id($results[$i]->BabyId))}}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif" class="check-neonatal" data-neonatal-id="{{$results[$i]->NeonatalId}}" data-baby-id="{{SiteHelpers::encrypt_id($results[$i]->BabyId)}}">
                                    {{  $results[$i]->BabyName }}
                                </a>
                                @else
                                <a class="check-neonatal" data-neonatal-id="{{$results[$i]->NeonatalId}}" data-baby-id="{{SiteHelpers::encrypt_id($results[$i]->BabyId)}}">
                                    {{  $results[$i]->BabyName }}
                                </a>
                                @endif
                            </td>
                            <td>{{  $results[$i]->BMrNo }}</td>
                            <td>
                                @if(date('Y',strtotime($results[$i]->DOB)) > 1970) 
                                {{  date('d-m-Y',strtotime($results[$i]->DOB)) }}
                                @endif
                            </td>
                        </tr>
                        @endfor
                        @else
                        <tr>
                            <td colspan="4" class="text-center"> <span>{{ Lang::get('home.nicu_summary_no_records')}}</span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <div class="dataTables_footer clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                                    {{ Lang::get('home.nicu_summary_showing') }} {{$pagination['limit'][0]}} {{ Lang::get('home.nicu_summary_to') }} {{$pagination['limit'][1]}} {{ Lang::get('home.nicu_summary_of') }} {{$pagination['total']}} {{ Lang::get('home.nicu_summary_entries') }} {{ @$search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_paginate paging_bootstrap pagination_footer">
                                    <ul class="pagination">
                                        <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                                            <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ $url }}?page={{ $pagination['previous'] }}@endif">&#8592; {{ Lang::get('home.nicu_summary_previous') }}</a>
                                        </li>
                                        @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                                        <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                            <a class='sort_with_page' href="{{ $url }}?page={{ $i }}">{{$i}}</a>
                                        </li>
                                        @endfor
                                        <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                            <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ $url }}?page={{ $pagination['next'] }}@endif">{{ Lang::get('home.nicu_summary_next') }} &#8594; </a>  
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
    
    // $('#search').click(function() {
    //     $('#search-form').submit();
    // });
    
    // $('.sorting_by').on('click', function(e) {
    //     e.preventDefault();
    //     var sortby       = $(this).data('field');
    //     pagination(sortby);
    // });
    
    // $('.sort_with_page').click(function(e){
    //     e.preventDefault();
    //     var sorting_param = $('#limit-form').serialize();
    //     var link          = $(this).attr('href');
    //     var searchText    = $('input[name="search_txt"]').val();
    //     window.location   = link + '&search_txt=' + searchText + '&' + sorting_param;
    // });
    
    // $('select[name="limit"]').on('change',function(e) {
    //     e.preventDefault();
    //     pagination();
    // });
    
    // function pagination(sortby) {
    //     var pagination_url = $('#limit-form').attr('action');
    //     var limit          = $('select[name="limit"] option:selected').val();
    //     var searchText     = $('input[name="search_txt"]').val();    
    //     var sorting_param  = $('#limit-form').serialize();
    //     var sorting_param1 = sorting_param.split('&sortorder=')[0];
    //     var sorting_param2 = sorting_param.split('&sortorder=')[1];

    //     if (sortby) {
    //         $('#sortby').val(sortby);
    //         if (sorting_param2 == 'desc') {
    //             var sortorder = 'asc';
    //             $('#sortorder').val(sortorder);
    //         } else {
    //             var sortorder = 'desc';
    //             $('#sortorder').val(sortorder);
    //         }
    //         window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
    //     } else {
    //         window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
    //     }
    // }

    // $('#admission_status').change(function () {
    //      var value = $(this).val();
    //     var pagination_url = "{{ url('nicu-discharge-main-list') }}";
    //     if ($(this).is(':checked')) {
    //         window.location = pagination_url + '/discharged';
    //     }
    //     else {
    //         window.location = pagination_url ;
    //     }
    // });

$(document).on('click', '.check-neonatal', function(e) {
  var neonatal_id = $(this).attr('data-neonatal-id');
  var baby_id = $(this).attr('data-baby-id');
  if (neonatal_id == '') {    
    e.preventDefault();
    // bootbox.confirm("Please, complete the 'Neonatal Performa'.",function(confirmed){
    //   if(confirmed){
    //     window.location = "{{ action('Registration\NeonatalController@create')}}/"+baby_id;
    //   }
    // });
    bootbox.dialog({
      message: "Please, complete the 'Neonatal Performa'.",
      buttons: {
        ok: {
          label: "Later",
          className: "btn-danger"
        },
        confirm: {
          label: "Go To Neonatal Performa",
          className: "btn-success",
          callback: function() {
            window.location = "{{ action('Registration\NeonatalController@create')}}/"+baby_id;
          }
        }
      }
    });
  }
});
</script>
@endsection
