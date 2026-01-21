@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
@if(!Session::has('NeonatalDichargeList'))
@php $actionUrl = action('Registration\NeonatalController@index') @endphp
@else
@php $actionUrl = action('Registration\NeonatalController@neonatalDichargelist') @endphp
@endif
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">{{ Lang::get('home.neonatal_dashboard')}}</a>
        </li>
        <li class="current">
            @if(Session::has('NeonatalDichargeList'))
            <a href="{{ $actionUrl }}">Neonatal Discharge Details</a>
            @else
            <a href="{{ $actionUrl }}">{{ Lang::get('home.neonatal_proforma') }}</a>
            @endif
        </li>
    </ul>
    <ul class="pull-right list-none">
        <li>
            <a href="{{ action('Search\NeonatalController@create') }}" title="search" class="btn btn-info btn-basic-shadow create-btn-spacing pull-right mr-33 search-btn">
            <i class="fa fa-search"></i> 
            <span>{{ Lang::get('home.neonatal_advanced_search') }}</span>
            </a>  
        </li>
    </ul>
</div>
@php $hides='true'; @endphp
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12 col-sm-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>@if(Session::has('NeonatalDichargeList')) Neonatal Discharge Details @else {{ Lang::get('home.neonatal_proforma') }}@endif</h4>
                @if(in_array('NEONATAL',$write_permission) && !Session::has('NeonatalDichargeList'))
                <a href="{{ action('Registration\NeonatalController@chooseBaby') }}" title="" class="btn btn-info btn-basic-shadow create-btn-spacing pull-right create-btn">
                <i class="fa fa-plus "></i> 
                <span>{{ Lang::get('home.neonatal_create_new') }} </span>
                </a>  
                @endif                     
            </div>
            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-xs-4 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                    {!! Form::open(['url' => $actionUrl, 'method' => 'get', 'id' => 'limit-form']) !!}
                                    <select name="limit"  size="1" aria-controls="data-list">
                                    <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                                    <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                                    <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                                    <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                                    <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                    </select><span class="hidden-xs">{{ Lang::get('home.neonatal_records')}}</span>
                                    {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                    {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                                    {!! Form::close() !!}
                                    </label>
                                </div>
                            </div>
                            {!! Form::open(['url' => $actionUrl , 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!}
                            <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                <div class="input-group">
                                    <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                    <input type="text" aria-controls="data-list" class="form-control" name="search_txt"  value="{!! @$search['search_txt'] !!}" placeholder="Search">
                                    <a href="{{ $actionUrl }}"  class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered  table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyName') }}">{{ Lang::get('home.neonatal_baby_name')}}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BMrNo') }}" data-hide="phone,tablet" >{{ Lang::get('home.mrn')}}</th>
                            <th class="visible-xs">More</th>
                            <th class="sorting_by sorting_icon hidden-xs @if($order['sortby'] == 'TestDate') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('TestDate') }}" data-hide="phone,tablet">{{ Lang::get('home.neonatal_entry_date') }}</th>
                            <th class="sorting_by sorting_icon hidden-xs @if($order['sortby'] == 'DOB') sorting_{{$order['sortorder']}}_icon @endif"  data-field="{{ SiteHelpers::encrypt_id('DOB') }}"data-hide="phone,tablet">{{ Lang::get('home.neonatal_dob')}}</th>
                            <th class="hidden-xs"> Print</th>
                            <th class="hidden-xs hide"> Edited Print</th>
                            @if($hides=='true')
                            @if(in_array('NEONATAL',$delete_permission))
                            <th class="hidden-xs">{{ Lang::get('home.neonatal_delete')}}</th>
                            @endif
                            @endif                              
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($results) > 0 )
                        @for ($i = 0; $i <  @count($results); $i++)
                        <tr>
                            <td>
                                <a class="icon @if(!in_array('NEONATAL',$write_permission)) permission-denied @endif edit-content-link" href="@if(in_array('NEONATAL',$write_permission)) {{ action('Registration\NeonatalController@edit', SiteHelpers::encrypt_id($results[$i]->NeonatalId)) }} @else javascript:void(0); @endif">
                                {{  $results[$i]->BabyName }}
                                </a>
                            </td>
                            <td>{{  $results[$i]->BMrNo }}</td>
                            <td class="visible-xs">
                                <a href="#">
                                <span class="glyphicon glyphicon-calendar hidden-lg" aria-hidden="true"  data-toggle="tooltip" data-original-title="Test Date : {!!   date('d-m-Y',strtotime($results[$i]->TestDate)) !!} &#13; Date of birth: {!!date('d-m-Y',strtotime($results[$i]->DOB)) !!}"></span>
                                </a> 
                            </td>
                            <td class="hidden-xs">{{  date('d-m-Y',strtotime($results[$i]->TestDate)) }}</td>
                            <td class="hidden-xs">@if(date('Y',strtotime($results[$i]->DOB)) > 1970) {{  date('d-m-Y',strtotime($results[$i]->DOB)) }} @endif</td>
                            @if($hides=='true')
                            @php $neo_id=SiteHelpers::encrypt_id($results[$i]->NeonatalId) ; @endphp
                            @endif  
                            <td class="hidden-xs">
                                <a class="icon btn btn-warning btn-view" href="{{ action('Registration\NeonatalController@show', SiteHelpers::encrypt_id($results[$i]->NeonatalId)) }}" title="Generated Print">
                                <i class="fa fa-print"></i> 
                                </a>
                            </td>
                            <td class="hidden-xs text-center hide">
                                @if($results[$i]->edited)
                                <a class="icon btn btn-default btn-view open-doc-editor" href="{{ action('Registration\NeonatalController@getAbbreviatedsummaryShow', \SiteHelpers::encrypt_id($results[$i]->BabyId) .'?id='. $results[$i]->NeonatalId) }}" title="Final Print">
                                <i class="fa fa-file-word-o"></i> 
                                </a>
                                @else 
                                -
                                @endif
                            </td>
                            @if(in_array('NEONATAL',$delete_permission))
                            <td class="hidden-xs text-center">
                                <a class="icon btn btn-danger btn-remove mr-10" href="javascript:void(0);" onclick="DeleteData({{ $results[$i]->NeonatalId }}, {{$results[$i]->hasAdmission}})" title="Remove Record">
                                <i class="fa fa-trash"></i> 
                                </a>
                            </td>
                            @endif
                        </tr>
                        @endfor
                        @else
                        <tr>
                            <td colspan="6" class="text-center"><span> No Record Found </span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <div class="dataTables_footer clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                                    {{ Lang::get('home.neonatal_showing') }} {{$pagination['limit'][0]}} {{ Lang::get('home.neonatal_to') }} {{$pagination['limit'][1]}} {{ Lang::get('home.neonatal_of') }} {{$pagination['total']}} {{ Lang::get('home.neonatal_entries') }} {{ @$search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 pagination-xs">
                                <div class="dataTables_paginate paging_bootstrap pagination_footer">
                                    <ul class="pagination">
                                        <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                                            <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{url($actionUrl.'?page='.$pagination['previous'])}}@endif">&#8592; {{ Lang::get('home.neonatal_previous') }}</a>
                                        </li>
                                        @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                                        <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                            <a class='sort_with_page' href="{{url('neonatal?page='.$i)}}">{{$i}}</a>
                                        </li>
                                        @endfor
                                        <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                            <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{url($actionUrl.'?page='.$pagination['next'])}}@endif">{{ Lang::get('home.neonatal_next') }} → </a>  
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
<!--
    DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK 
    -->                
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}
@endsection
@section('scripts')
<script type="text/javascript">
    function DeleteData(id, hasAdmission) {
      if (hasAdmission == true) {
       Showalert('warning','Access denied : This neonatal proforma refered to a postnatal or nicu admission !');
     } else {
    
      bootbox.confirm("Are you sure?",function(confirmed){
        if(confirmed){
          $("#DeleteForm").attr('action',"{{ $actionUrl }}/"+id);
          $("#DeleteForm").submit();
        }
      });
    
    }
    
    }
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
      placement : 'top'
    });
    });
    
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
