@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="current">
            <a href="{{ action('Snomed\SnomedCodeController@index') }}">Snomed Map Local</a>
        </li>                                         
    </ul>
</div>
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Snomed Map Local</h4>
                <a href="{{ action('Snomed\SnomedCodeController@create') }}" class="btn btn-basic-shadow btn-info pull-right create-btn-spacing"><i class="fa fa-plus"></i><span>Create New</span></a>
            </div>
            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-xs-4 col-sm-6 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                        {!! Form::open(['url' => action('Snomed\SnomedCodeController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                                        <select name="limit"  size="1" aria-controls="data-list">
                                            <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif>10</option>
                                            <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                                            <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                                            <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                                            <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                        </select><span class="hidden-xs">records per page</span>
                                            {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                            {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                                        {!! Form::close() !!}
                                    </label>
                                </div>
                            </div>
                            {!! Form::open(['url' => action('Snomed\SnomedCodeController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!}
                            <div class="col-xs-8 col-sm-6 col-md-4 pull-right"> 
                                <div class="input-group">
                                    <span id="search" class="input-group-addon">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </span>
                                    <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ $search_txt }}" placeholder="Search"  class="form-control">
                                    <a href="{{ action('Snomed\SnomedCodeController@index') }}" class="input-group-addon">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                </div>   
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-responsive" id="data-list">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th class="sorting_by sorting_icon @if($order['sortby'] == 'column_name') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('column_name') }}">Column Name</th>
                        <th class="sorting_by sorting_icon @if($order['sortby'] == 'snomed_code') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('snomed_code') }}">Snomed Code</th>
                        <th class="sorting_by sorting_icon @if($order['sortby'] == 'loinc_code') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('loinc_code') }}">Lonic Code</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                @if(count($lists) > 0)
                    @php $i = 0 @endphp     
                    @foreach($lists as $list)   
                        <tr class="detailinfo">
                            <td>{{ $i+1 }}</td>                    
                            <td>{{ $list->column_name }}</td>                    
                            <td>{{ $list->snomed_code }}</td>                    
                            <td>{{ $list->loinc_code }}</td> 
                            <td>
                                <a class="icon" href="{{ action('Snomed\SnomedCodeController@edit',$list->id) }}">
                                    <i class="fa fa-pencil"></i>
                                    <span class="hidden-phone">Edit</span>
                                </a>
                            </td>
                            <td>
                                <a class="icon" href="javascript:void(0);" onclick="DeleteData({{$list->id}})">
                                  <i class="fa fa-remove"></i> 
                                  <span class="hidden-phone">Delete</span>
                                </a>
                            </td>                 
                        </tr>                
                        @php $i = $i+1 @endphp 
                    @endforeach
                @else 
                    <tr>
                        <th colspan="6" class="text-center">No record found</th>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="row">
          <div class="col-md-12">
            <div class="dataTables_footer clearfix">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries {{ $search_txt != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                </div>
              </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="dataTables_paginate paging_bootstrap pagination_footer">
                    <ul class="pagination">    
                      <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                        <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('snomedct-list?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                      </li>
                    @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                      <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                        <a class='sort_with_page' href="{{ url('snomedct-list?page='.$i) }}">{{$i}}</a>
                      </li>  
                    @endfor
                      <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                        <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('snomedct-list?page='.$pagination['next']) }}@endif">Next &#8594; </a>  
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
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!} 

@endsection
@section('scripts')
<script type="text/javascript">
    function DeleteData(id){
        bootbox.confirm("Are you sure?",function(confirmed) {
            if(confirmed) {
                $("#DeleteForm").attr('action',"{{ action('Snomed\SnomedCodeController@index') }}/"+id);
                $("#DeleteForm").submit();
            }
        });
    }
    
    $('#search').click(function() {
        $('#search-form').submit();
    });

    $('.sorting_by').on('click', function(e) {
        e.preventDefault();
        var sortby        = $(this).data('field');
        pagination(sortby);
    });

    $('.sort_with_page').click(function(e){
        e.preventDefault();
        var sorting_param = $('#limit-form').serialize();
        var link          = $(this).attr('href');
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
