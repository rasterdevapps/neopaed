@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
  <ul id="breadcrumbs" class="breadcrumb">
     <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
     <li class="current"><a href="{{ action('Registration\OpController@index') }}">OP Registration</a></li>                                                
 </ul>
 <ul class="pull-right list-none">
    <li>
        <a class="btn btn-info btn-basic-shadow mtb-4 mr-33 create-btn search-btn" href="{{ action('Search\SearchOpController@OpReportSearch') }}"> 
          <i class="fa fa-search"></i>  
          <span>Advanced Search</span>
      </a>
  </li>
</ul>                   
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
         <div class="widget-header">
            <h4>OP Registration</h4>
            @if(in_array('OP_REG',$write_permission))
            <a href="{{ action('Registration\OpController@chooseBaby') }}" title="Create New" class="btn btn-basic-shadow create-btn-spacing btn-info pull-right create-btn"><i class="fa fa-plus "></i> <span>Create New</span></a> 
            @endif                               
        </div>
        <div class="widget-content">
            <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                <div class="row">
                    <div class="dataTables_header clearfix">
                        <div class="col-xs-4 col-sm-6 col-md-6">
                            <div id="data-list_length" class="dataTables_length">
                                <label class="data_limit">
                                    {!! Form::open(['url' => action('Registration\OpController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                                    <select name="limit"  size="1" aria-controls="data-list">
                                        <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                                        <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                                        <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                                        <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                                        <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                    </select>
                                    <span class="hidden-xs">records per page </span>
                                    {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                    {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                                    {!! Form::close() !!}
                                </label>
                            </div>
                        </div>
                        {!! Form::open(['url' => action('Registration\OpController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                        <div class="col-xs-8 col-sm-4 col-md-4 pull-right">  
                            <div class="input-group">
                              <span id="search" class="input-group-addon">
                                <i class="glyphicon glyphicon-search"></i>
                            </span>
                            <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{  @$search['search_txt'] }}" placeholder="Search">
                            <a href="{{ action('Registration\OpController@index')}}" class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <table class="table table-striped table-bordered table-responsive"  id="data-list">
               <thead>
                <tr>
                    <th colspan="3" style="background-color: lightcoral;">{{ ValuelistHelpers::mas_doctors_list(7) }}</th>
                </tr>
                <tr>
                    <th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyName') }}" style="border-left: 1px solid #00c3ff;width: 30%;">Baby Name</th>
                    <th class="sorting_by sorting_icon @if($order['sortby'] == 'BMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BMrNo') }}" data-hide="phone" style="width: 10%;">{{ Lang::get('home.mrn') }}</th>
                    <th class="sorting_by sorting_icon @if($order['sortby'] == 'DOB') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('DOB') }}" data-hide="phone,tablet" style="width: 10%;">Date of birth</th>
                </tr>
            </thead>
            <tbody>
                @if(count($results) > 0 )
                @php 
                    $opdate = $results->unique('OpDate')->pluck('OpDate')->toArray();
                @endphp
                @foreach($opdate as $op_date)
                    <tr>
                        <td colspan="6" style="background-color: #00c3ff;">
                            <h3 class="m-0"><b>{{ date('d-m-Y',strtotime($op_date))  }}</b></h3>
                        </td>
                    </tr>
                    @php 
                        $result = $results->where('OpDate',$op_date);
                    @endphp
                    @foreach($result as $result_details)
                        <tr>
                            <td class="text-captialize">
                                <a href="{{ action('Registration\OpController@OpsubList',SiteHelpers::encrypt_id($result_details->BabyId)) }}?seen_by={{SiteHelpers::encrypt_id(8)}}">{{  $result_details->BabyName }}</a>
                            </td>
                            <td>{{  $result_details->BMrNo }}</td>
                            <td>{{  (date('Y',strtotime($result_details->DOB)) > 1970) ? date('d-m-Y',strtotime($result_details->DOB)) : ''  }}</td>
                        </tr>
                    @endforeach    
                @endforeach    
                @else
                    <tr class="text-center">
                        <td colspan="4">No Record Found </td>
                    </tr>  
                @endif  
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-12">
                <div class="dataTables_footer clearfix">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                            Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries {{ $search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="dataTables_paginate paging_bootstrap pagination_footer">
                            <ul class="pagination">
                                <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                                    <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('out-patient?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                                </li>
                                @for ($i = $pagination['start']; $i <= $pagination['end']; $i++)
                                <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                    <a class='sort_with_page' href="{{ url('out-patient?page='.$i) }}">{{$i}}</a>
                                </li>
                                @endfor
                                <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                    <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('out-patient?page='.$pagination['next']) }}@endif">Next &#8594; </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> <!-- /.col-md-12 -->
</div>
<!-- /.row -->            
@endsection
@section('scripts')
<script type="text/javascript">

    $('#search').click(function() {
        $('#search-form').submit();
    });

        $('.sorting_by').on('click', function(e) {
            e.preventDefault();
            var sortby       = $(this).data('field');
                pagination(sortby);
            });

                $('.sort_with_page').click(function(e){
                    e.preventDefault();
                    var sorting_param = $('#limit-form').serialize();
                        var link      = $(this).attr('href');
                            var searchText    = $('input[name="search_txt"]').val();
                                window.location   = link + '&search_txt=' + searchText + '&' + sorting_param;
                            });

                            $('select[name="limit"]').on('change',function(e) {
                                e.preventDefault();
                                pagination();
                            });

                                function pagination(sortby) {
                                  var pagination_url = $('#limit-form').attr('action');
                                  var limit          = $('select[name="limit"] option:selected').val();
                                  var searchText     = $('input[name="search_txt"]').val();    
                                  var sorting_param  = $('#limit-form').serialize();
                                  var sorting_param1 = sorting_param.split('&sortorder=')[0];
                                  var sorting_param2 = sorting_param.split('&sortorder=')[1];

                                  if (sortby) {
                                    $('#sortby').val(sortby);
                                    if (sorting_param2 == 'desc') {
                                      var sortorder = 'asc';
                                      $('#sortorder').val(sortorder);
                                  } else {
                                      var sortorder = 'desc';
                                      $('#sortorder').val(sortorder);
                                  }
                                  window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
                              } else {
                                window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
                            }

                        }
                    </script>
                    @endsection
