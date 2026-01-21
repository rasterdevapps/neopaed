@extends('app')
@section('content')

<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li class="current">
			<a href="{{ action('Ward\PatientLogHistoryController@index') }}">Patient Log</a>
		</li>                                                
	</ul>					
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="widget box table-view-shadow">
			<div class="widget-header">
			  <h4>Patient Log</h4>                              
			</div>
      <div class="widget-content">
        <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          <div class="row">
            <div class="dataTables_header clearfix">
              <div class="col-xs-4 col-sm-6 col-md-6">
                <div id="data-list_length" class="dataTables_length">
                  <label class="data_limit">
                    {!! Form::open(['url' => action('Ward\PatientLogHistoryController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                      <select name="limit" size="1" aria-controls="data-list">
                        <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                        <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                        <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                        <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                        <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                      </select>
                      <span class="hidden-xs">records per page</span>
                        {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                        {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                    {!! Form::close() !!}
                  </label>
                </div>
              </div>
              {!! Form::open(['url' => action('Ward\PatientLogHistoryController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!}
              <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                <div class="input-group">
                      <span id="search" class="input-group-addon">
                         <i class="glyphicon glyphicon-search"></i>
                      </span>
                      <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ $search_txt }}" placeholder="Search">
                      <a href="{{ action('Ward\PatientLogHistoryController@index') }}" class="input-group-addon">
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
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyName') }}">Baby Name</th>
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'BMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BMrNo') }}"data-hide="phone">{{ Lang::get('home.mrn') }}</th>
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'Sex') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('Sex') }}" data-hide="phone">Sex</th>
              <th class="visible-xs">More</th>
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'DOB') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('DOB') }}" data-hide="phone,tablet">DOB</th>
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyBloodGroup') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('BabyBloodGroup') }}" data-hide="phone,tablet">Blood Group</th>
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'ward_name') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('ward_name') }}">Ward</th>
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'room_no') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('room_no') }}">Room</th>
              <th class="sorting_by sorting_icon @if($order['sortby'] == 'bed_no') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('bed_no') }}">Bed</th>
              <th class="hidden-xs">Pump Status </th>
            </tr>
          </thead>
          <tbody>
           @if(count($results) > 0)
            @foreach ($results as $result)
              <tr>
                <td>              
                  <a class="icon baby-edit" data-edit-url="{{ action('Ward\PatientLogHistoryController@edit', $result->id) }}" href="javascript:void(0);">
                    {{  $result->BabyName }}
                  </a>  
                </td>
                <td>{{  $result->BMrNo }}</td>
                <td class="hidden-xs">{{  $result->Sex }}</td>
                <td class="visible-xs">
                  <a href="#">
                  <!-- <span class="fa fa-info-circle hidden-lg" aria-hidden="true"  data-toggle="tooltip" data-original-title="Sex : {!!  $result->Sex  !!} &#13; Blood Group: {!!   $result->BabyBloodGroup !!}"></span> -->
                  <i class="fa fa-info-circle bs-tooltip hidden-lg" data-original-title="Sex : {!!  $result->Sex  !!} &#13; Blood Group: {!!   $result->BabyBloodGroup !!}"></i>
                   </a> 
                  </td>
                <td class="hidden-xs">{{ (date('Y',strtotime($result->DOB)) > 1970) ? date('d-m-Y',strtotime($result->DOB)) : '' }}</td>
                <td class="hidden-xs">{{  $result->BabyBloodGroup }}</td>
                <td class="hidden-xs">{{  $result->ward_name }}</td>
                <td class="hidden-xs">{{  $result->room_no }}</td>
                <td class="hidden-xs">{{  $result->bed_no }}</td>
                <td class="hidden-xs">
                   <button type="button" data-patient-id = "{{ $result->id }}" class="btn connect-pump btn-primary">Connect Pump
                  </button>
                </td>
              </tr>
            @endforeach
            @else
              <tr><td colspan="9" class="text-center"> No Record Found</td></tr>
            @endif
          </tbody>
    	</table>      
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
                        <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('patient-history?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                      </li>
                    @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                      <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                        <a class='sort_with_page' href="{{ url('patient-history?page='.$i) }}">{{$i}}</a>
                      </li>  
                    @endfor
                      <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                        <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('patient-history?page='.$pagination['next']) }}@endif">Next &#8594; </a>  
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
<!-- DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK -->                    
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}
</div>

<div class="modal fade flow-control-modal" id="patient-bed-log" role="dialog">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          <h5 class="modal-title">
            <h3>Bed Log</h3>

          </h5>  
        </div>
        <div class="modal-body">
         
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
</div>


@endsection
@section('scripts')
<script type="text/javascript">

$('.connect-pump ').click(function() {
  var patientId = $(this).data('patient-id');
  
    $.ajax({
           type:'GET',
           url:'{{ url("update-bed-details") }}'+'/'+patientId,

           beforeSend:function() {
           },
           success:function(responseText) {
            Showalert(responseText.type,responseText.message);
              window.location = "{{url('patient-history')}}";
           },
           complete:function(responseText) {
           },
           error:function(responseText) {
           }

    });

});
$('.baby-edit').click(function(e) {
 var editUrl = $(this).data('edit-url');
 $('#patient-bed-log').modal({backdrop: 'static', show: true });
 
 $.ajax({
           type:'GET',
           url:editUrl,
           beforeSend:function() {
           },
           success:function(responseText) {
            $('#patient-bed-log .modal-body').html(responseText.results);

           },
           complete:function(responseText) {
           },
           error:function(responseText) {
           }

    });

});

$(document).on('click','.update-bed-log',function() {
  
  $.ajax({
           type:'PATCH',
           data:$('#bed-log-edit').serialize(),
           url:$('#bed-log-edit').attr('action'),
           beforeSend:function() {
           },
           success:function(responseText) {
            Showalert(responseText.type, responseText.message);
            
           },
           complete:function(responseText) {
              $('#patient-bed-log').modal("hide");
              window.location = "{{url('patient-history')}}";
           },
           error:function(responseText) {
           }

    });
})

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
