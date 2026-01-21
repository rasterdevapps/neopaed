@extends('app')
@section('content')
<style type="text/css">
    input {
    font-weight: bold !important;
    font-size: 16px !important;
    }
    .score-highlighter {
    background-image: linear-gradient(to top, #f89406, #e99013, #db8b1c, #cd8622, #c08128);
    padding: 3px 10px;
    font-weight: bold;
    border-radius: 16px;
    color: white;
    }
</style>
<?php $write_permission = session('write_permission'); ?>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">{{ Lang::get('home.nurse_hour_wise_dashboard') }}</a>
        </li>
        <li class="current">
            <a href="{{ action('Nurse\NurseSheetController@getHeroScore') }}">HeRo Score</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>HeRo Score</h4>
            </div>
            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix" >
                            <div class="col-xs-4 col-sm-6 col-md-6">
                                <div id="data-list_length" class="dataTables_length ">
                                    <label class="data_limit">
                                    {!! Form::open(['url' => action('Nurse\NurseSheetController@getHeroScore'), 'method' => 'get', 'id' => 'limit-form']) !!}
                                    <select name="limit"  size="1" aria-controls="data-list">
                                    <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
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
                            <div class="col-xs-8 col-sm-6 col-md-4">
                                <button class="btn btn-success save-button-shadow export-hero-score pull-right ml-15"> Export </button>
                                <!-- <span class="text-center error-message pull-right" style="padding: 7px 0px;"><b><i class="fa fa-info-circle bs-tooltip" style="color: black;"></i>&nbspPlease, fill all fields for data filter</b></span> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-15 mb-20 p-10 multi-search display-grid" style="border: 1px solid #dddddd; border-radius: 5px; float: unset;">
                    {!! Form::model($search, ['url' => action('Nurse\NurseSheetController@getHeroScore'), 'method' => 'get', 'id' => 'hero-search']) !!}
                    <div class="col-md-3">
                        {{ Lang::get('home.mrn') }}:<span class="required-label"></span> {{ Form::text('mrn',null,['class'=>'form-control']) }}
                        {{ Form::hidden('min_date_time',@$min,['class'=>'form-control']) }}
                        {{ Form::hidden('max_date_time',@$max,['class'=>'form-control']) }}
                    </div>
                   <!--  <div class="col-md-3">
                        From Date:<span class="required-label"></span> {{ Form::text('fromdate',null,['class'=>'form-control']) }}
                    </div>
                    <div class="col-md-3">
                        To Date:<span class="required-label"></span> {{ Form::text('todate',null,['class'=>'form-control']) }}
                    </div> -->
                    <div class="col-md-3" style="display: flex;flex-direction: row;justify-content: center;align-items: center;height: 70px;">
                        <button class="btn btn-primary save-button-shadow mr-10 search"> Search </button>
                        <button class="btn btn-default save-button-shadow mr-10 reset">Reset</button>
                    </div>
                    {!! Form::close() !!} 
                </div>
                {{-- @if (!empty($search['mrn']) && !empty($search['fromdate']) && !empty($search['todate'])) --}}
                @if (!empty($search['mrn']))
                <table class="table table-striped table-bordered table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'result_date_time') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('result_date_time') }}">Date & Time</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'mean') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('mean') }}">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if (!empty($search['mrn']) && !empty($search['fromdate']) && !empty($search['todate'])) --}}
                        @if (!empty($search['mrn']))
                        @php $babydtl = $results->unique('BMrNo')->pluck('BMrNo')->toArray();   @endphp
                        @if (count($babydtl) > 0)
                        @foreach($babydtl as $key => $value) 
                        @php $i = 0; @endphp 
                        @php $result = $results->where('BMrNo', $value);  @endphp     
                        @foreach($result as $results_key => $results_value)
                        @if ($i == 0)
                        <tr>
                        {{ Form::hidden('baby_name',@$results_value->BabyName,['class'=>'form-control']) }}
                        {{ Form::hidden('baby_id',@$results_value->BabyId,['class'=>'form-control']) }}
                            <td colspan="3" style="background-color: #00ff4e38;">{{  $results_value->BabyName }} - {{  $results_value->BMrNo }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ is_null($results_value->result_date_time) ? '' : date('d-m-Y H:i',strtotime($results_value->result_date_time))  }}</td>
                            <td><span class="score-highlighter">{{ number_format($results_value->mean, 2) }}</span></td>
                        </tr>
                        @php $i += 1; @endphp 
                        @endforeach
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3">No Record Found</td>
                        </tr>
                        @endif
                        @else
                        <tr>
                            <td colspan="3"></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="row">
                    @if (!empty($search['mrn']))
                    <div class="col-md-12">
                        <div class="dataTables_footer clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                                    Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries {{ @$search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_paginate paging_bootstrap pagination_footer">
                                    <ul class="pagination">
                                        <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                                            <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('hero?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                                        </li>
                                        @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                                        <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                            <a class='sort_with_page' href="{{ url('hero?page='.$i) }}">{{$i}}</a>
                                        </li>
                                        @endfor
                                        <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                            <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('hero?page='.$pagination['next']) }}@endif">Next &#8594; </a>  
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-md-12">
                        <div class="dataTables_footer clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                                    Showing 0 to 0 of 0 entries
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_paginate paging_bootstrap pagination_footer">
                                    <ul class="pagination">
                                        <li class="prev disabled">
                                            <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('hero?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                                        </li>
                                        <li class="next disabled">
                                            <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('hero?page='.$pagination['next']) }}@endif">Next &#8594; </a>  
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->      
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
      var mrn            = $('input[name="mrn"]').val();    
      var fromdate       = $('input[name="fromdate"]').val();    
      var todate         = $('input[name="todate"]').val();    
      window.location = link + '&mrn=' + mrn + '&fromdate=' + fromdate + '&todate=' + todate;
    });
    
    $('select[name="limit"]').on('change',function(e) {
      e.preventDefault();
      pagination();
    });
    function pagination(sortby) {
      var pagination_url = $('#limit-form').attr('action');
      var limit          = $('select[name="limit"] option:selected').val();
      var mrn            = $('input[name="mrn"]').val();    
      var fromdate       = $('input[name="fromdate"]').val();    
      var todate         = $('input[name="todate"]').val();    
      var sorting_param  = $('#limit-form').serialize();
      var sorting_param1 = sorting_param.split('&sortorder=')[0];
      var sorting_param2 = sorting_param.split('&sortorder=')[1];
    
      if (sortby) {
        $('#sortby').val(sortby);
        if (sorting_param2 == 'desc') {
          var sortorder = 'asc';
          $('#sortorder').val(sortorder);
        } 
        else {
          var sortorder = 'desc';
          $('#sortorder').val(sortorder);
        }
        window.location = pagination_url + '?page=1&mrn=' + mrn + '&fromdate=' + fromdate + '&todate=' + todate + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
      } 
      else {
        window.location = pagination_url + '?page=1&mrn=' + mrn + '&fromdate=' + fromdate + '&todate=' + todate + '&' + sorting_param;
      }
    
    }
    
    $('input[name="fromdate"], input[name="todate"]').datepicker({
      dateFormat: 'dd-mm-yy'
    });
    
    $('.reset').click(function() {
      $('input, select').val('');
    });
    
    $(document).ready(function() {
    
    
      $('.search').on('click', function(event) {
    
        $('#hero-search input').each(function() {
          $(this).rules("add", {
            required: true
          });
        });
    
        if($('#hero-search').validate().form()) {
          return true;
        } else {
          return false;
        }
      });
    
      $('#hero-search').validate();
    
      var url_string = window.location.href
      var url = new URL(url_string);
      var mrn = url.searchParams.get("mrn");
      var fromdate = url.searchParams.get("fromdate");
      var todate = url.searchParams.get("todate");
    
      // if (mrn != null && fromdate != null && todate != null) {
      if (mrn != null) {
        $('.export-hero-score').prop('disabled', false);
      } else {
        $('.export-hero-score').prop('disabled', true);      
      }
    
    });
    
    $('.export-hero-score').on('click', function(){
      var mrn            = $('input[name="mrn"]').val();    
      var baby_id        = $('input[name="baby_id"]').val();    
      var min_date_time  = $('input[name="min_date_time"]').val();    
      var max_date_time  = $('input[name="max_date_time"]').val();    
      var baby_name      = $('input[name="baby_name"]').val();    
      // var fromdate       = $('input[name="fromdate"]').val();    
      // var todate         = $('input[name="todate"]').val();    
      window.location  = "{{ url('download-hero-score') }}"+'/'+mrn+'/'+baby_name+'/'+baby_id+'/'+min_date_time+'/'+max_date_time;
    });
</script>
@endsection
