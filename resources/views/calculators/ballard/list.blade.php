@extends('app')
@section('content')
<?php $delete_permission = session('delete_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
            <i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="current">
            <a href="{{ action('Calculators\BallardController@index') }}">Ballard Score</a>
        </li>                                                
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Ballard Score</h4>
                <a href="{{ action('Calculators\BallardController@create') }}" title="Create New" class="btn btn-shadow-special btn-info pull-right create-btn-spacing create-btn"><i class="fa fa-plus "></i> <span>Create New</span></a>                                
            </div>
            <div class="widget-content">    
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix" >
                            <div class="col-xs-4 col-sm-6 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                        {!! Form::open(['url' => action('Calculators\BallardController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                                        <select name="limit"  size="1" aria-controls="data-list">
                                            <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                                            <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                                            <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                                            <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                                            <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                        </select><span class="hidden-xs">Records per page</span>
                                        {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                        {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                                        {!! Form::close() !!}
                                    </label>
                                </div>
                            </div>
                            {!! Form::open(['url' => action('Calculators\BallardController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                            <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                <div class="input-group">
                                    <span id="search" class="input-group-addon">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </span>
                                    <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ @$search['search_txt'] }}" placeholder="Search">
                                    <a href="{{ action('Calculators\BallardController@index') }}" class="input-group-addon">
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
                            <th>S.No.</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyName') }}">BabyName</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BMrNo') }}" data-hide="phone">{{ Lang::get('home.mrn') }}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'TotalScore') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('TotalScore') }}">Score</th>
                            <th>Print</th>                                
                            @if(in_array('TEST_CULTURE',$delete_permission))
                            <th>Delete</th>                                
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($results) > 0 )
                        @for ($i = 0; $i <  @count($results); $i++)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>
                              <a class="icon" href="{{ action('Calculators\BallardController@edit',SiteHelpers::encrypt_id($results[$i]->BallardId)) }}">
                                  {{  $results[$i]->BabyName }}
                              </a>
                          </td>
                          <td>{{  $results[$i]->BMrNo }}</td>
                          <td>{{  $results[$i]->TotalScore }}</td>
                                <td class="center-align-phone">
                                    <a class="btn btn-warning btn-view" href="{{ action('Calculators\BallardController@print', SiteHelpers::encrypt_id($results[$i]->BallardId)).'?closewinlink=list' }}" title="Print">
                                        <i class="fa fa-print"></i> 
                                    </a>
                                </td> 
                          @if(in_array('TEST_CULTURE',$delete_permission))
                          <td class="center-align-phone">

                            <a class="btn btn-danger btn-view" href="javascript:void(0);" onclick="DeleteData({{ $results[$i]->BallardId}})">
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
                                Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries {{ @$search['search_txt'] != '' ? '(filtered from ' . $getTotal . ' total entries)' : '' }}
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="dataTables_paginate paging_bootstrap pagination_footer">
                                <ul class="pagination">    
                                    <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                                        <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('ballard-score?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                                    </li>
                                    @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                                    <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                        <a class='sort_with_page' href="{{ url('ballard-score?page='.$i) }}">{{$i}}</a>
                                    </li>  
                                    @endfor
                                    <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                        <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('ballard-score?page='.$pagination['next']) }}@endif">Next &#8594; </a>  
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
<div class="modal fade bs-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 id="myModalLabel" class="modal-title">Baby Details</h4>
            </div>
                        <div class="modal-body">
                <div class="container-fluid">
                  <div class="row">
                      <div class="col-md-6">
                       <p>Name: <span class="col-name"></span></p>
                   </div>
                   <div class="col-md-6">
                       <p>Birth Status: <span class="col-birthstatus"></span></p>
                   </div>
               </div>
               <div class="row">
                   <div class="col-md-6">
                     <p>{{ Lang::get('home.mrn') }}: <span class="col-bmrno"></span></p>
                 </div>
                 <div class="col-md-6">
                     <p>Mother Name: <span class="col-mothername"></span></p>
                 </div>

             </div>
             <div class="row">
                 <div class="col-md-6">
                   <p>Birth City: <span class="col-city"></span></p>
               </div>
               <div class="col-md-6">
                   <p>Sex: <span class="col-sex"></span></p>
               </div>
           </div>
           <div class="row">
            <div class="col-md-6">
             <p>Birth Weight: <span class="col-birthweight"></span></p>                    
         </div>
         <div class="col-md-6">
             <p>Birth Order: <span class="col-birthorder"></span></p>

         </div>                    
     </div>
     <div class="row">
         <div class="col-md-6">
           <p>DOB: <span class="col-dob"></span></p>
       </div>
       <div class="col-md-6">
           <p>TOB: <span class="col-tob"></span></p>
       </div>
   </div>    
   <div class="row">
     <div class="col-md-6">
       <p>Father Spoken Languages : <span class="col-fspoken"></span></p>
   </div>                
   <div class="col-md-6">
       <p>Mother Spoken Languages: <span class="col-mspoken"></span></p>
   </div>
</div>
<div class="row">
 <div class="col-md-6">
   <p>Background Details: <span class="col-background"></span></p>
</div>
<div class="col-md-6">
   <p>Confidential Background Details: <span class="col-confident"></span></p>
</div>
</div>
<div class="row">
 <div class="col-md-6">
   <p>Baby\'s Blood Group: <span class="col-bloodgroup"></span></p>
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
        bootbox.confirm("Are you sure?",function(confirmed){
            if(confirmed){
                $("#DeleteForm").attr('action',"{{ action('Calculators\BallardController@index') }}/"+id);
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
