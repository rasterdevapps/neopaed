@extends('app')
@section('content')

<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
  <ul id="breadcrumbs" class="breadcrumb">
    <li>
      <i class="icon-home"></i>
      <a href="{{ url('/') }} ">{{ Lang::get('home.nicu_problem_summary_dashborad') }}</a>
    </li>
    <li class="current">
      <a href="{{ action('Reports\ProblemDischargeController@dischargeBabylist') }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif">@if(isset($summary_type) && $summary_type == 'interim') Interim Summary ( Problem Based ) @else {{ Lang::get('home.nicu_summary_summary') }} @endif</a>
      <!-- <a href="{{ action('Reports\ProblemDischargeController@dischargeBabylist') }}">{{ Lang::get('home.nicu_problem_summary_discharge') }}</a> -->
    </li>                                                
  </ul>
</div>
<!-- /Breadcrumbs line -->

<!--=== Page Content ===-->
<div class="row row-spacing">
  <div class="col-md-12">
    <div class="widget box table-view-shadow">
      <div class="widget-header">
        <h4>@if(isset($summary_type) && $summary_type == 'interim') Interim Summary ( Problem Based ) @else {{ Lang::get('home.nicu_problem_summary_discharge') }} @endif</h4>              
                @include('admission_filter')
      </div>
      <div class="widget-content">
        <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          <div class="row">
            <div class="dataTables_header clearfix" >
              <div class="col-xs-4 col-sm-6 col-md-6">
                <div id="data-list_length" class="dataTables_length">
                  <label class="data_limit">

                    @if(isset($summary_type) && $summary_type == 'interim') 
                     @php $url = action('Reports\ProblemDischargeController@dischargeBabylist').'/interim'; @endphp
                    @else 
                     @php $url = action('Reports\ProblemDischargeController@dischargeBabylist'); @endphp
                    @endif
                    {!! Form::open(['url' => $url, 'method' => 'get', 'id' => 'limit-form']) !!}
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

              {!! Form::open(['url' => $url, 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                  <div class="input-group">
                    <span id="search" class="input-group-addon">
                       <i class="glyphicon glyphicon-search"></i>
                    </span>
                    <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ @$search['search_txt'] }}" placeholder="Search">
                    <a href="{{ action('Reports\ProblemDischargeController@dischargeBabylist') }}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif" class="input-group-addon" id="search-reset">
                      <i class="glyphicon glyphicon-remove"></i>
                    </a>
                  </div>
                </div> 
              {!! Form::close() !!}
            </div>
          </div>
        </div>              
        <table class="table table-bordered table-responsive">
          <thead>
            <tr>
              <th>{{ Lang::get('home.nicu_problem_summary_sno') }}</th>
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyName') }}">{{ Lang::get('home.nicu_problem_summary_baby_name') }}</th>
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'BMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BMrNo') }}" data-hide="phone,tablet">{{ Lang::get('home.mrn') }}</th>
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'DOB') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('DOB') }}">{{ Lang::get('home.nicu_problem_summary_dob') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($results) > 0)
              @for ($i = 0; $i <  @count($results); $i++)
                <tr>
                  <td>{{ $i+1 }}</td>
                  <td>
                    @if (isset($results[$i]->NeonatalId))
                    <a href="{{ url('problems-discharge-admission-list/'.SiteHelpers::encrypt_id($results[$i]->BabyId))}}@if(isset($summary_type) && $summary_type == 'interim')/interim @endif" class="check-neonatal" data-neonatal-id="{{$results[$i]->NeonatalId}}" data-baby-id="{{SiteHelpers::encrypt_id($results[$i]->BabyId)}}">
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
              <tr><td colspan="4" class="text-center"> <span>{{ Lang::get('home.nicu_problem_summary_no_record') }}</span></td></tr>
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
                      <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('problems-discharge-baby-list?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                    </li>
                    @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                      <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                        <a class='sort_with_page' href="{{ url('problems-discharge-baby-list?page='.$i) }}">{{$i}}</a>
                      </li> 
                    @endfor
                    <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                      <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('problems-discharge-baby-list?page='.$pagination['next']) }}@endif">Next &#8594; </a>  
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
</div> <!-- /.row -->
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
    //     var link      = $(this).attr('href');
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
