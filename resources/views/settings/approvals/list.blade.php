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
			<a href="{{ action('Settings\DeleteApprovalController@index') }}">Delete Approvals</a>
		</li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Delete Approvals</h4>
                <div class="pull-right">
                    <button data-approve-url="{{ action('Settings\DeleteApprovalController@getprocess', 1)}}" class="btn btn-info btn-basic-shadow approve pull-right create-btn-spacing">Approve All</button>
                    <button data-undo-url="{{ action('Settings\DeleteApprovalController@getprocess', 2)}}" class="btn btn-info btn-basic-shadow undo-records pull-right create-btn-spacing btn-spacing-right">Undo All</button>
                </div>
			</div>
			<div class="widget-content">        
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix" >
                            <div class="col-xs-4 col-sm-6 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                        {!! Form::open(['url' => action('Settings\DeleteApprovalController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
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
                            {!! Form::open(['url' => action('Settings\DeleteApprovalController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                                <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                    <div class="input-group">
                                        <span id="search" class="input-group-addon">
                                            <i class="glyphicon glyphicon-search"></i>
                                        </span>
                                        <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ @$search['search_txt'] }}" placeholder="Search">
                                        <a href="{{ action('Settings\DeleteApprovalController@index') }}" class="input-group-addon">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </a>
                                    </div>                
                                </div>              
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>                            
		        <table class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="approve_all_select[]" class="approve-all"></th>
                            <th class="hidden-phone">S.No.</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'Name') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('Name') }}">Baby Name</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'ModuleName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('ModuleName') }}" class="hidden-phone">Module Name</th>                                            
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'UserDeleted') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('UserDeleted') }}" class="hidden-phone">User Deleted</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'AdmissionDate') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('AdmissionDate') }}" class="hidden-phone">Admission Date</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'DateDeleted') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('DateDeleted') }}">Deleted Date</th>
                            <th class="center-align-phone">Approve</th>                          
                            <th>Undo</th>                                                                      
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($results) > 0)
                        @for ($i = 0; $i <  @count($results); $i++)
                        <tr>
                            <td><input type="checkbox" name="approve_all[]" value="{{ $results[$i]->Id }}" class="sub-list"></td> 
                            <td class="hidden-phone">{{  $i+1 }}</td>
                            <td>{{  $results[$i]->Name }} @if(SiteHelpers::action_exists($results[$i]->ModuleController.'@edit', SiteHelpers::encrypt_id($results[$i]->ModuleId)))<a class="icon " href="{{ action($results[$i]->ModuleController.'@edit',SiteHelpers::encrypt_id($results[$i]->ModuleId)) }}"><i class="fa fa-pencil"></i></a> @endif</td>
                            <td class="hidden-phone">{{  $results[$i]->ModuleName }}</td>
                            <td class="hidden-phone">{{  $results[$i]->UserName }}</td>                                            
                            <td class="hidden-phone">{{  date('Y',strtotime($results[$i]->AdmissionDate))>2000? date('d-m-Y',strtotime($results[$i]->AdmissionDate)):'' }}</td>                                            
                            <td>{{  date('d-m-Y',strtotime($results[$i]->DateDeleted)) }}</td>   
                            @php $approve = url('approve/'.$results[$i]->Id.'/processdata/1'); @endphp                                         
                            <td class="center-align-phone">
                                <a class="icon " href="javascript:void(0);" onclick="DeleteData('{{ $approve }}')"><i class="fa fa-check"></i> <span class="hidden-phone">Approve</span></a>
                            </td>
                            @php $delete = url('approve/'.$results[$i]->Id.'/processdata/2'); @endphp 
                            <td>
                                <a class="icon" href="javascript:void(0);" onclick="DeleteData('{{ $delete }}')"><i class="fa fa-undo"></i> <span class="hidden-phone">Undo</span></a>
                            </td>
                        </tr>
                        @endfor
                        @else
                        <tr>
                            <td colspan="9">No Records Found</td>
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
                                            <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('approve?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                                        </li>
                                        @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                                            <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                                <a class='sort_with_page' href="{{ url('approve?page='.$i) }}">{{$i}}</a>
                                            </li>  
                                        @endfor
                                        <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                            <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('approve?page='.$pagination['next']) }}@endif">Next &#8594; </a>  
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
<!-- DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK -->  
{!! Form::open(['method'=> 'DELETE','url' => '/','id'=>'DeleteForm']) !!}
<input type="hidden" name="approve_ids" value="">
{!! Form::close() !!}                                
@endsection
@section('scripts')
<script type="text/javascript">
    $('.approve').prop('disabled', true);
    $('.undo-records').prop('disabled', true);
    $('.approve-all').click(function() {

        if ($(this).prop('checked') == true) {

            $('.approve').prop('disabled', false);
            $('.undo-records').prop('disabled', false);
          
           $('.sub-list').each(function() {
              $(this).prop('checked',true);
           }); 

        } else {

            $('.approve').prop('disabled', true);
            $('.undo-records').prop('disabled', true);

            $('.sub-list').each(function() {
              $(this).prop('checked',false);
           }); 

        }

    });  

    $('.approve').click(function() {
        var url = $(this).data('approve-url');
        var approveIds = [];

        $('input[name="approve_all[]"]:checked').each(function() {
            approveIds.push($(this).val());
        });
        approveIds = JSON.stringify(approveIds);
        bootbox.confirm("Are you sure?",function(confirmed) {
            if (confirmed) {
                $('input[name="approve_ids"]').val(approveIds);
                $("#DeleteForm").attr('action',url);
                $("#DeleteForm").submit();
            } else {
                $('input[name="approve_ids"]').val('');
            }
        });  
    }); 

    $('.undo-records').click(function() {
        var url = $(this).data('undo-url');
        var approveIds = [];

        $('input[name="approve_all[]"]:checked').each(function() {
            approveIds.push($(this).val());
        });
        approveIds = JSON.stringify(approveIds);
        bootbox.confirm("Are you sure?",function(confirmed) {
            if (confirmed) {
                $('input[name="approve_ids"]').val(approveIds);
                $("#DeleteForm").attr('action',url);
                $("#DeleteForm").submit();
            } else {
                $('input[name="approve_ids"]').val('');
            }
        });
  
    }); 

    function DeleteData(url) {
    	bootbox.confirm("Are you sure?",function(confirmed) {
    		if(confirmed){
    			$("#DeleteForm").attr('action',url);
    			$("#DeleteForm").submit();
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
