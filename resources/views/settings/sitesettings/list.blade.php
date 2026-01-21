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
			<a href="javascript://">Site Settings</a>
		</li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->

<!-- Page Header -->
<div class="page-header">
<!-- <div class="page-title">
		<h3>Dashboard</h3>
	</div>-->
</div>
<!-- /Page Header -->

<!--=== Page Content ===-->
<div class="row">
    <div class="col-md-12">
        <div class="widget box">
			<div class="widget-header">
				<h4>Site Settings</h4>
                 @if(in_array('SITE_CONFIG',$write_permission))
				 <a href="{{ action('Settings\SiteSettingController@create') }}" title="Create Settings " class="btn btn-info pull-right create-btn-spacing">
					 <i class="fa fa-plus "></i> 
					 <span>Create New</span>
				 </a> 
                 @endif                               
			</div>
    <div class="widget-content no-padding">
        <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
            <div class="row">
                <div class="dataTables_header clearfix">
                    <div class="col-md-6">
                        <div id="data-list_length" class="dataTables_length">
                            <label class="data_limit">
                                {!! Form::open(['url' => action('Registration\OpController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                                <select name="limit"  size="1" aria-controls="data-list" onchange="form.submit();">
                                    <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                                    <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                                    <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                                    <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                                    <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                </select>

                                <span class="hidden-xs">records per page</span>
                                {!! Form::close() !!}
                            </label>
                        </div>
                    </div>
     {!! Form::open(['url' => action('Registration\OpController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                    <div class="col-md-6">
                        <a href="{{ action('Registration\OpController@index') }}" class="btn btn-sm search-reset">
                            <i class="fa fa-remove"></i>
                        </a>
                        <div class="dataTables_filter" id="data-list_filter">
                            <label>
                                <div class="input-group">
                                    <span id="search" class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <input type="text" aria-controls="data-list" name="search_txt" placeholder="Search" class="form-control">
                                </div>
                            </label>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
		<table class="table table-striped table-bordered table-responsive"  id="data-list">
			<thead>
                <tr>
                    <th>Baby Name</th>
                    <th data-hide="phone">{{ Lang::get('home.mrn') }}</th>
                    <th data-hide="phone,tablet">Op Date</th>
                    @if(in_array('SITE_CONFIG',$write_permission))
                    <th>Edit</th>                    
                    <th>Delete</th>                                                    
                    @endif            
				    <th>Preview</th>                                
				    <th>Print</th>                                                                
                </tr>
            </thead>
            <tbody>
            @for ($i = 0; $i <  @count($results); $i++)
                <tr>
                    <td>{{  $results[$i]->BabyName }}</td>
                    <td>{{  $results[$i]->BMrNo }}</td>
                    <td>{{  date('d-m-Y',strtotime($results[$i]->OpDate)) }}</td>
                    @if(in_array('SITE_CONFIG',$write_permission))
					<td  class="center-align-phone">
					    <a class="icon" href="{{ action('Registration\OpController@edit', $results[$i]->OpId) }}">
						    <i class="fa fa-pencil"></i> 
						    <span class="hidden-phone">Edit</span>
					    </a>
					</td>
                    <td  class="center-align-phone">
                        <a class="icon" href="javascript:void(0);" onclick="DeleteData({{ $results[$i]->OpId}})">
                            <i class="fa fa-remove"></i> 
                            <span class="hidden-phone">Delete</span>
                        </a>
                    </td>
                    @endif                                 
                    <td  class="center-align-phone">
                        <a class="icon" href="javascript:void(0);" onclick="ShowModal({!!  $results[$i]->OpId !!});" >
                            <i class="fa fa-eye"></i> 
                            <span class="hidden-phone">View</span>
                        </a>
                    </td>
             			
                    <td  class="center-align-phone">
                        <a class="" href="{{ action('Registration\OpController@show', $results[$i]->OpId) }}">
                        <i class="fa fa-print"></i> 
                        <span class="hidden-phone">Print</span>
                        </a>
                    </td>
                </tr>
            @endfor
            </tbody>
		</table>   
    </div>
  </div>
</div> <!-- /.col-md-12 -->
					<!--
                		DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK 
                	-->                    
                   {!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
                    {!! Form::close() !!} 
</div>
<div class="row">
    <div class="col-md-12">
        <div class="dataTables_footer clearfix">
            <div class="col-md-6">
                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                   Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries
                </div>
            </div>
            <div class="col-md-6">
               <div class="dataTables_paginate paging_bootstrap pagination_footer">
                    <ul class="pagination">
                        <li class="prev @if($pagination['previous'] == 1)disabled @endif">
                           <a href="{{url('out-patient?page='.$pagination['previous'])}}">&#8592; Previous</a>
                        </li>
                        @for ($i = $pagination['start']; $i < $pagination['end']; $i++)
                         <li class="@if($i == Request::query('page')) active @endif">
                            <a href="{{url('out-patient?page='.$i)}}">{{$i}}</a>
                         </li>
                        @endfor
                        <li class="next">
                           <a href="{{url('out-patient?page='.$pagination['next'])}}">Next &#8594; </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
