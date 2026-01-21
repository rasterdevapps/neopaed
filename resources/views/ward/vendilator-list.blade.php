@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ action('Ward\BabyWardController@index') }}">Ventilator Data</a>
        </li>
        <li class="current">
            <a href="javascript::void(0);">{{$baby_details->BabyName.'-'.$baby_details->BMrNo}}</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Ventilator Data</h4>
                <a href="{{ url('ward-dashboard') }}" type="button" class="btn create-btn-spacing btn-basic-shadow btn-primary pull-right print-tag">
                    <i class="fa fa-external-link" aria-hidden="true"></i>
                    <span>Back To Ward Dashbord</span>
                </a> 
            </div>
            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-xs-4 col-sm-6 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                        {!! Form::open(['url' => action('fhirformate\VendilatorFormatController@VendilatorList',['babyId'=>SiteHelpers::encrypt_id($baby_details->BabyId), 'admissionId'=>SiteHelpers::encrypt_id($admissionid)]), 'method' => 'get', 'id' => 'limit-form']) !!}
                                        <select name="limit" @if(isset($result) && count($results) == 0) disabled="true" @endif size="1" aria-controls="data-list">
                                            <option value="10"   @if(isset($pagination) && $pagination['limits'] == 10)   selected="selected" @endif>10</option>
                                            <option value="25"   @if(isset($pagination) && $pagination['limits'] == 25)   selected="selected" @endif>25</option>
                                            <option value="50"   @if(isset($pagination) && $pagination['limits'] == 50)   selected="selected" @endif>50</option>
                                            <option value="100"  @if(isset($pagination) && $pagination['limits'] == 100)  selected="selected" @endif>100</option>
                                            <option value="1000" @if(isset($pagination) && $pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                            </select>
                                            <span class="hidden-xs">records per page</span>
                                            {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                            {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                                        {!! Form::close() !!}
                                    </label>
                                </div>
                            </div>
                            {!! Form::open(['url' => action('fhirformate\VendilatorFormatController@VendilatorList',['babyId'=>SiteHelpers::encrypt_id($baby_details->BabyId), 'admissionId'=>SiteHelpers::encrypt_id($admissionid)]), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                            <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                        <div class="input-group">
                                            <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                            <input type="text" aria-controls="data-list" name="search_txt" placeholder="Search" value="{{ @$search_txt }}" class="form-control">
                                            <a href="{{ action('fhirformate\VendilatorFormatController@VendilatorList',['babyId'=>SiteHelpers::encrypt_id($baby_details->BabyId), 'admissionId'=>SiteHelpers::encrypt_id($admissionid)]) }}" class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></a>
                                        </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="overflow-auto">
                <table class="table table-striped table-bordered table-hover table-checkable"  id="data-list">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th class="date-width sorting_by sorting_icon @if($order['sortby'] == 'result_date_time') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('result_date_time') }}">Date & Time</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'local_description') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('local_description') }}">Description</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'device_model') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('device_model') }}">Device Name</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'low') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('low') }}">Low</th>
                            <th class="quartile-width sorting_by sorting_icon @if($order['sortby'] == 'first_quartile') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('first_quartile') }}">Open</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'mean') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('mean') }}">Mid</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'close') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('close') }}">Close</th>
                            <th class="quartile-width sorting_by sorting_icon @if($order['sortby'] == 'last_quartile') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('last_quartile') }}">High</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($vendilator_details) > 0)
                            @php $i = 0; @endphp
                            @foreach($vendilator_details as $observation)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ date('d-m-Y H:i',strtotime($observation->result_date_time)) }}</td>
                                    <td>{{ $observation->local_description }}</td>
                                    <td>{{ $observation->device_model }}</td>
                                    <td>{{ number_format((float)$observation->low, 2) }}</td>
                                    <td>{{ number_format((float)$observation->first_quartile, 2) }}</td>
                                    <td>{{ number_format((float)$observation->mean, 2) }}</td>
                                    <td>{{ number_format((float)$observation->close, 2) }}</td>
                                    <td>{{ number_format((float)$observation->last_quartile, 2) }}</td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="9">No Record found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="dataTables_footer clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                                    Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries {{ @$search_txt != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                                </div>
                            </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="dataTables_paginate paging_bootstrap pagination_footer">
                                        <ul class="pagination">
                                            <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                                                <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('list-vendilator-values/'.SiteHelpers::encrypt_id($baby_details->BabyId).'/'.SiteHelpers::encrypt_id($admissionid).'?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                                            </li>
                                            @for ($i = $pagination['start']; $i <= $pagination['end']; $i++)
                                            <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                                <a class='sort_with_page' href="{{ url('list-vendilator-values/'.SiteHelpers::encrypt_id($baby_details->BabyId).'/'.SiteHelpers::encrypt_id($admissionid).'?page='.$i) }}">{{$i}}</a>
                                            </li>
                                            @endfor
                                            <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                                <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('list-vendilator-values/'.SiteHelpers::encrypt_id($baby_details->BabyId).'/'.SiteHelpers::encrypt_id($admissionid).'?page='.$pagination['next']) }}@endif">Next &#8594; </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
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
