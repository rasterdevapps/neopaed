@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
<!-- Breadcrumbs line -->
    <div class="crumbs bread-crumbs-shadow">
        <ul id="breadcrumbs" class="breadcrumb">
            <li>
                <i class="icon-home"></i>
                <a href="/">Dashboard</a>
            </li>
            <li class="current">
                <a href="{{ action('Masters\SurgeonController@index') }}">Surgeons</a>
            </li>
        </ul>

    </div>
    <!-- /Breadcrumbs line -->

    <!-- Page Header -->
    <!-- <div class="page-header">
      
    </div> -->
    <!-- /Page Header -->

    <!--=== Page Content ===-->
    <div class="row row-spacing">
        <div class="col-md-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4>Surgeons <i class="fa fa-info-circle bs-tooltip" data-placement="right"
                                       data-original-title="NICU admission->Admission Pro forma->Basics->Surgeon"></i>
                    </h4>
                    @if(in_array('MAS_SURGEON',$write_permission))
                        <a href="{{ action('Masters\SurgeonController@create') }}" title=""
                           class="btn btn-info pull-right create-btn-spacing"><i class="fa fa-plus "></i> <span>Create New</span></a>
                    @endif
                </div>
                <div class="widget-content no-padding">

                   <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                      <div class="row">
                       <div class="dataTables_header clearfix" >
                         <div class="col-md-6">
                           <div id="data-list_length" class="dataTables_length">
                            <label class="data_limit">
                {!! Form::open(['url' => action('Masters\SurgeonController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                                <select name="limit"  size="1" aria-controls="data-list" onchange="form.submit();">
                                  <option value="10" @if($pagination['limit'] == 10) selected="selected" @endif  >10</option>
                                  <option value="25" @if($pagination['limit'] == 25) selected="selected" @endif>25</option>
                                  <option value="50" @if($pagination['limit'] == 50) selected="selected" @endif>50</option>
                                  <option value="100" @if($pagination['limit'] == 100) selected="selected" @endif>100</option>
                                  <option value="1000" @if($pagination['limit'] == 1000) selected="selected" @endif>All</option>
                                </select><span class="hidden-xs">records per page</span>
                                {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}

                    {!! Form::close() !!}
                            </label>
                           </div>
                         </div>
                {!! Form::open(['url' => action('Masters\SurgeonController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                        <div class="col-md-6">
                          <a href="{{ action('Masters\SurgeonController@index') }}" class="btn btn-sm search-reset">
                            <i class="fa fa-remove"></i>
                          </a>
                          <div class="dataTables_filter" id="data-list_filter">
                            <label>
                              <div class="input-group">
                               <span id="search" class="input-group-addon">
                                 <i class="fa fa-search"></i>
                               </span>
                               <input type="text" aria-controls="data-list" name="search_txt" value="{{ $search['search_txt'] }}" placeholder="Search" class="form-control">
                              </div>
                            </label>
                          </div>
                        </div>
               {!! Form::close() !!}
                       </div>
                      </div>
                    </div>
                    <table class="table table-striped table-bordered table-responsive" id="data-list">
                        <thead>
                        <tr>
                            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('id') }}">
                            S.No.
                            </th>
                            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('surgeon_name') }}">
                             Surgeon Name
                            </th>
                            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('status') }}">
                            Status
                            </th>
                            @if(in_array('MAS_SURGEON',$write_permission))
                                <th>Edit</th>
                                @endif
                            @if(in_array('MAS_SURGEON',$delete_permission))
                                <th>Delete</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($results) > 0)
                        @php $j = $results->firstItem(); @endphp
                        @for ($i = 0; $i <  @count($results); $i++)
                            <tr>
                                <td>{{ $j }}</td>
                                <td>{{  $results[$i]->surgeon_name }}</td>
                                <td>{{  ($results[$i]->status==1)? 'Active':'Inactive'  }}</td>
                                @if(in_array('MAS_SURGEON',$write_permission))
                                <td class="center-align-phone">
                                    <a class="icon" href="{{ action('Masters\SurgeonController@edit',$results[$i]->id ) }}">
                                     <i class="fa fa-pencil"></i> 
                                     <span class="hidden-phone">Edit</span>
                                    </a>
                                </td>
                                @endif
                            @if(in_array('MAS_SURGEON',$delete_permission))
                                <td class="center-align-phone">
                                    <a class="icon" href="javascript:void(0);" onclick="DeleteData({{$results[$i]->id}})">
                                    <i class="fa fa-remove"></i> 
                                    <span class="hidden-phone">Delete</span></a>
                                </td>
                                @endif
                            </tr>
                            @php $j++; @endphp
                        @endfor
                        @else
                          <tr><td colspan="5" class="text-center">No Record Found</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
    </div> <!-- /.row -->
    <!-- /Page Content -->
    {!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
    {!! Form::close() !!}
  <div class="row">
    <div class="col-md-12">
        <div class="dataTables_footer clearfix">
          <div class="col-md-6">
           <div class="dataTables_info" id="DataTables_Table_0_info">
             Showing {{ $results->firstItem() }} to {{ $results->lastItem()  }} of {{ $results->total() }} entries
           </div>
          </div>
        <div class="col-md-6">
          <div class="dataTables_paginate paging_bootstrap">
             <ul class="pagination">
                @if($results->currentPage()!=1)
                <li class="prev @if($results->currentPage() == 1) disabled @endif">
                  <a class="sort_with_page" href="{!! $results->previousPageUrl() !!}">&#8592; Previous</a>
                </li>
                @endif
                @if($results->currentPage() !=$results->lastPage()) 
                <li class="next @if($results->currentPage() == $results->lastPage()) disabled @endif">
                  <a class="sort_with_page" href="{!! $results->nextPageUrl() !!}">Next &#8594; </a>
                </li>
                 @endif
              </ul>
          </div>
        </div>
       
      </div>
    </div>
</div>                    
@endsection
@section('scripts')
    <script type="text/javascript">

    $('.sorting_by').click(function(e){
        e.preventDefault();
        $('#sortby').val($(this).data('field'));
           if($('#sortorder').val()=='desc'){
              $('#sortorder').val('asc');
           }else{
              $('#sortorder').val('desc');
           }
       $('#limit-form').submit();
    
    });

    $('.sort_with_page').click(function(e){
      e.preventDefault();
      var sorting_param=$('#limit-form').serialize();
      var link =$(this).attr('href');
      window.location=link+'&'+sorting_param;
    });

        function DeleteData(id) {
            bootbox.confirm("Are you sure?", function (confirmed) {
                if (confirmed) {
                    $("#DeleteForm").attr('action', "{{ action('Masters\SurgeonController@index') }}/" + id);
                    $("#DeleteForm").submit();
                }
            });
        }
    </script>
@endsection      
