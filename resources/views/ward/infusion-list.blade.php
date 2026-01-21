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
            <a href="{{ action('Ward\BabyWardController@index') }}">Infusion List</a>
        </li>
        <li class="current">
            <a href="javascript:void();">{{ $baby_details->BabyName}}</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Infusion List</h4>
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
                                        {!! Form::open(['url' => action('fhirformate\InfusionPumpFormatController@infusionSyringelist',['babyId'=>SiteHelpers::encrypt_id($baby_details->BabyId), 'admissionId'=>SiteHelpers::encrypt_id($admissionid)]), 'method' => 'get', 'id' => 'limit-form']) !!}
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
                            {!! Form::open(['url' => action('fhirformate\InfusionPumpFormatController@infusionSyringelist',['babyId'=>SiteHelpers::encrypt_id($baby_details->BabyId), 'admissionId'=>SiteHelpers::encrypt_id($admissionid)]), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!}
                                <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                            <div class="input-group">
                                                <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                                <input type="text" aria-controls="data-list" name="search_txt" placeholder="Search" value="{{ @$search_txt }}" class="form-control">
                                                <a href="{{ action('fhirformate\InfusionPumpFormatController@infusionSyringelist',['babyId'=>SiteHelpers::encrypt_id($baby_details->BabyId), 'admissionId'=>SiteHelpers::encrypt_id($admissionid)]) }}" class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></a>
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
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'result_time') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('result_time') }}">Date & Time</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'pharmacological_name') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('pharmacological_name') }}">Pharmacological Name</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'infused') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('infused') }}">Infused</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'prescription.rate') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('prescription.rate') }}">Rate</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'remain_volume') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('remain_volume') }}">Remain Vol</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'remain_time') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('remain_time') }}">Remain Time</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'pressure') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('pressure') }}">Pressure</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'pressure_level') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('pressure_level') }}">Pressure Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($infusionDetails) && count($infusionDetails) > 0)
                            @php $i = 0; @endphp
                            @foreach($infusionDetails as $value)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($value->result_time)) }}</td>
                                    <td>{{ (isset($value->brand_name)) ? $value->brandname . ' / ' . $value->generic_pharmacological_name : '' }}</td>
                                    <td>{{ number_format($value->infused, 2) }}</td>
                                    <td>{{ number_format($value->prescription_rate, 2) }}</td>
                                    <td>{{ number_format($value->remain_volume, 2) }}</td>
                                    <td>{{ $value->remain_time }}</td>
                                    <td>{{ number_format($value->pressure, 2) }}</td>
                                    <td>{{ $value->pressure_level }}</td>
                                </tr>
                            @php $i++;  @endphp
                        @endforeach
                        @else
                            <tr><td colspan="9" class="text-center"> <span>No Records Found</span></td> </tr>
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
                                                <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('list-infusion-values/'.SiteHelpers::encrypt_id($baby_details->BabyId).'/'.SiteHelpers::encrypt_id($admissionid).'?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                                            </li>
                                            @for ($i = $pagination['start']; $i <= $pagination['end']; $i++)
                                            <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                                <a class='sort_with_page' href="{{ url('list-infusion-values/'.SiteHelpers::encrypt_id($baby_details->BabyId).'/'.SiteHelpers::encrypt_id($admissionid).'?page='.$i) }}">{{$i}}</a>
                                            </li>
                                            @endfor
                                            <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                                <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('list-infusion-values/'.SiteHelpers::encrypt_id($baby_details->BabyId).'/'.SiteHelpers::encrypt_id($admissionid).'?page='.$pagination['next']) }}@endif">Next &#8594; </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div>
        </div>
    </div> <!-- /.col-md-12 -->
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
