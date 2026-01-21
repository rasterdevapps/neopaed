@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current"><a href="{{ action('Settings\ComplaintsController@index') }}">Complaints</a></li>                                                
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing" id="complaints">
    <div class="col-md-12">
        <div class="widget box table-view-shadow no-padding">
            <div class="widget-header">
                <h4>Complaints</h4>
                <a title="Create New" class="btn btn-basic-shadow btn-info pull-right create-btn-spacing complaints"><i class="fa fa-plus"></i> <span>Create New</span></a>
            </div>

            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-xs-4 col-sm-6 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                    {{ Form::open(['url' => action('Settings\ComplaintsController@index'), 'method' => 'get', 'id' => 'limit-form']) }}
                                        <select name="limit" size="1" aria-controls="data-list">
                                            <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif>10</option>
                                            <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                                            <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                                            <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                                            <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                        </select>
                                        <span class="hidden-xs">records per page</span>
                                        {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                        {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                                    {{ Form::close() }}
                                    </label>
                               </div>
                            </div>
                            {{ Form::open(['url' => action('Settings\ComplaintsController@index'), 'method' => 'get', 'id' => 'search-form', 'class' => 'search_form']) }} 
                                <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                    <div class="input-group">
                                        <span id="search" class="input-group-addon">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </span>
                                        <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ $search_txt }}" placeholder="Search" class="form-control">
                                        <a href="{{ action('Settings\ComplaintsController@index') }}" class="input-group-addon">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </a>
                                    </div>               
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>               
                <table class="table table-bordered" id="data-list">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('title') }}">Complaints</th>
                            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('Status') }}">Status</th>
                            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('DateAdded') }}">Added Date</th>
                            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('DateModified') }}">Modified Date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($complaints) > 0)
                            @php $i = 1 @endphp
                            @foreach($complaints as $complaint)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td class="title">{{ $complaint->title }}</td>
                                    <td>{{ $complaint->Status }}</td>
                                    <td>{{ date('d-m-Y',strtotime($complaint->DateAdded)) }}</td>
                                    <td>{{ date('d-m-Y',strtotime($complaint->DateModified)) }}</td>
                                    <td>
                                        <a class="center" onclick="DeleteComplaint('{{$complaint->complaints_id}}','{{$folder_name}}');">
                                            <i class="fa fa-remove" aria-hidden="true"></i>
                                            <span>Delete</span>
                                        </a>
                                    </td>                                    
                                </tr>   
                                @php $i = $i+1 @endphp 
                            @endforeach
                        @else 
                            <tr>
                                <td colspan="6" class="text-center">No record found</td>
                            </tr>
                        @endif
                    </tbody>
                </table> 
<div class="row">
    <div class="col-md-12">
        <div class="dataTables_footer clearfix">
            <div class="col-md-6">
                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                    Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="dataTables_paginate paging_bootstrap pagination_footer">
                  <ul class="pagination">    
                    <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                      <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('complaints?page='.$pagination['previous']) }}@endif">&#8592; {{ Lang::get('home.mother_previous') }}</a>
                  </li>
                  @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                  <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                    <a class='sort_with_page' href="{{ url('complaints?page='.$i) }}">{{$i}}</a>
                </li>  
                @endfor
                <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                  <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('complaints?page='.$pagination['next']) }}@endif">{{ Lang::get('home.mother_next') }} &#8594; </a>  
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
</div>
<div id="load-modal"></div>

<script>    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('.complaints').click(function(e) {   
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: '{{ action("Settings\ComplaintsController@create") }}',
                success: function(message) {
                    $('#load-modal').html(message.modal);
                    $('.edit').hide();
                    $('.create').show();
                    $('#complaints-modal').modal('show');
                },
            });
        }); 
        $('.complaint_id').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: e.target.href,
                success: function(message) {
                    $('#load-modal').html(message.modal);                    
                    $('.create').hide();
                    $('.edit').show();
                    $('#complaints-modal').modal('show');
                    complaint = message.complaints;
                    $('#title').val(complaint.title);
                    $('#made_by option[value='+complaint.madeby+']').attr('selected','selected');
                    if(complaint.userdetails == 0) {
                        $('#user_list').append('<option value="0" selected="selected">System</option>');
                    }
                    $('#user_list option[value='+complaint.userdetails+']').attr('selected','selected');
                    $('#description').val(complaint.description);
                    if (complaint.Status == 'Open') {
                        $('input[value=Open]').prop('checked', true);                       
                    } else if (complaint.Status == 'Pending') {
                        $('input[value=Pending]').prop('checked', true); 
                    } else if (complaint.Status == 'Completed') {
                        $('input[value=Completed]').prop('checked', true);  
                    } else if (complaint.Status == 'Not a issue') {
                        $('input[value="Not a issue"]').prop('checked', true);
                    }
                    if(complaint.userdetails == 0) {
                        $('#user_list').children('option').hide();
                        $('#user_list').append('<option value="0" selected="selected">System</option>');
                    }
                },                   
            });             
            $(document).on('click','#form_update',function(event) {            
                event.preventDefault();
                $.ajax({
                    type: 'PATCH',
                    url: e.target.name,
                    data: $('form').serialize(),
                    success: function(message) {
                        $('#complaints-modal').modal('hide');
                        Showalert('success',message.success);
                        setTimeout(function() {                         
                            location.href = "{{ action('Settings\ComplaintsController@index') }}";
                        }, 2000);   
                    }
                });                  
            });         
        }); 
        $(document).on('change','#made_by',function() {
            console.log('welcome');
            if ($('#made_by').val() == 'Human_error') {
                $('#user_list').children('option').show();
                $('#user_list').children('option:last').remove();
            }
            else {
                $('#user_list').children('option').hide();
                $('#user_list').append('<option value="0" selected="selected">System</option>');
            }
        });
        $(document).on('click','#form_save',function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ action("Settings\ComplaintsController@store") }}',
                data: $('form').serialize(),
                success: function(message) {
                    $('#complaints-modal').modal('hide');
                    Showalert('success',message.success);
                    setTimeout(function() {                         
                        location.href = "{{ action('Settings\ComplaintsController@index') }}";
                    }, 2000);   
                },
                error: function() {
                    alert('error');
                }
            });
        });
    });
function DeleteComplaint(id,folder_name) {
    bootbox.confirm("Are you sure?",function(confirmed) {
        if(confirmed) {
            $.ajax({
                type: "DELETE",
                // url: '/'+folder_name+'/complaints/'+id,
                url: '{{ action("Settings\ComplaintsController@index") }}/'+id,
                success: function(message) {
                    Showalert('info',message.info);
                    setTimeout(function() {                         
                        location.href = "{{ action('Settings\ComplaintsController@index') }}";
                    }, 2000); 
                }
            });
        }
    });
}

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
