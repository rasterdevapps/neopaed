@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{url('/')}}">Dashboard</a>
		</li>
		<li class="current">
			<a href="{{ action('Quality\QualityController@index') }}">{!! isset($navigate['module_name']) ? $navigate['module_name'] : '' !!} </a>
		</li>                                                
	</ul>
	<ul class="pull-right list-none">
	    <li>
	      <a href="{{ action('Search\SearchQualityController@create') }}" title="search" class="btn btn-info btn-basic-shadow mtb-4 pull-right mr-33">
	        <i class="fa fa-search"></i> 
	        <span>Advanced Search </span>
	      </a>  
	    </li>
    </ul>		
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Baby List</h4>    
				<a href="{{ action('Quality\QualityController@create') }}" title="Create New" class="btn create-btn-spacing btn-basic-shadow btn-info pull-right create-btn"><i class="fa fa-plus "></i> <span>Create New</span></a>   
				<a href="javascript:void(0);" id="export-excel" class="btn create-btn-spacing btn-basic-shadow btn-warning pull-right btn-spacing-right"><i class="fa fa-file-excel-o"></i> <span>Export</span></a>   
			</div>
			<div class="widget-content">  
			    <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
		            <div class="row">
			            <div class="dataTables_header clearfix" >
			                <div class="col-xs-4 col-sm-6 col-md-6">
			                    <div id="data-list_length" class="dataTables_length">
				                    <label class="data_limit">
				                     {!! Form::open(['url' => action('Quality\QualityController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
				                       <select class="limit-box" name="limit" @if(isset($baby_list) && count($baby_list) == 0) disabled="true" @endif size="1" aria-controls="data-list">
					                        <option value="10" @if(isset($pagination) && $pagination['limits'] == 10) selected="selected" @endif>10</option>
					                        <option value="25" @if(isset($pagination) && $pagination['limits'] == 25) selected="selected" @endif>25</option>
					                        <option value="50" @if(isset($pagination) && $pagination['limits'] == 50) selected="selected" @endif>50</option>
					                        <option value="100" @if(isset($pagination) && $pagination['limits'] == 100) selected="selected" @endif>100</option>
					                        <option value="1000" @if(isset($pagination) && $pagination['limits'] == 1000) selected="selected" @endif>All</option>
					                    </select><span class="hidden-xs">records per page</span>
					                    {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                        				{!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
				                      {!! Form::close() !!}
				                    </label>
			                    </div>
			                </div>
			                {!! Form::open(['url' => action('Quality\QualityController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
			                <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
			                <div class="input-group">
			                     <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
			                      <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ isset($search_txt) ?  $search_txt : '' }}" placeholder="Search">
			                     <a href="{{ action('Quality\QualityController@index') }}" class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></a>
			                  </div>                
			                </div>
			                {!! Form::close() !!}
			            </div>
		            </div>
		        </div>                  
			  <table class="table table-striped table-bordered table-responsive">
		  	  	<thead>
		  	  		<tr>
				  	  	<th>S.No</th>
				  	    <th class="sorting_by sorting_icon @if($order['sortby'] == 'mr_number') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('mr_number') }}">{{ Lang::get('home.mrn') }}</th>	 
				  	  	<th class="sorting_by sorting_icon @if($order['sortby'] == 'name') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('name') }}">Baby Name</th>
				  	  	<th class="sorting_by sorting_icon @if($order['sortby'] == 'dob') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('dob') }}">DOB</th>
				  	  	<th class="center-align-phone">Print</th>
			  	  	</tr>
		  	  	</thead>
		  	  	<tbody>
		  	  		@if(isset($baby_list) && count($baby_list) > 0 )
		  	  			@for ($i = 0; $i <  @count($baby_list); $i++)			  	  		
				  	  		<tr>
				  	  		   <td>{{ $i+1 }}</td>
				               <td><a href="{{ action('Quality\QualityController@edit', SiteHelpers::encrypt_id($baby_list[$i]->id)) }}">{{ $baby_list[$i]->mr_number }}</a></td>
				               <td>{{ $baby_list[$i]->name }}</td>
				               <td>  @if(!is_null($baby_list[$i]->dob) && date('Y',strtotime($baby_list[$i]->dob)) != '1970') {{ date('d-m-Y',strtotime($baby_list[$i]->dob)) }} @endif </td>
				               <td class="center-align-phone">
				               		<a class="btn btn-warning btn-view" href="{{ action('Quality\QualityController@print', SiteHelpers::encrypt_id($baby_list[$i]->babyId)) }}">
				                  		<i class="fa fa-print"></i> 
				                	</a>
				               </td>
				  	  		</tr>
			  	  		@endfor
			  	  	@else 
				  	  	<tr class="text-center">
				  	  		<td colspan="8"> No Record Found</td>
				  	  	</tr>	
			  	  	@endif		
		  	  	</tbody>
	  	  </table>
			 <div class="row">
			    <div class="col-md-12">
			        <div class="dataTables_footer clearfix">
			          <div class="col-md-6 col-sm-6 col-xs-12">
			           <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
			             Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries {{ $search_txt != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
			           </div>
			          </div>			      
		                <div class="col-md-6 col-sm-6 col-xs-12">
		                  <div class="dataTables_paginate paging_bootstrap pagination_footer">
		                    <ul class="pagination">    
		                      <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
		                        <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('quality-indicator?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
		                      </li>
		                    @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
		                      <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
		                        <a class='sort_with_page' href="{{ url('quality-indicator?page='.$i) }}">{{$i}}</a>
		                      </li>  
		                    @endfor
		                      <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
		                        <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('quality-indicator?page='.$pagination['next']) }}@endif">Next &#8594; </a>  
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

<div class="modal fade" id="export-baby" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="close-font">&times;</span>
              </button>
           <h5 class="modal-title">
          <h3 class="text-center text-white">Choose Fields To Be Export</h3>
            </h5>
        </div>
        <div class="row modal-body">
            {!! Form::model('',['url' => action('Quality\QualityController@exportbaby'),'method' => 'post', 'id'=>'export-sheet']) !!}

            <div class="col-md-12">
              <div class="col-md-6">
                 <div class="form-group">
                   {!! Form::label('file_name','Save As Name') !!}
                   {!! Form::text('file_name','baby-list',['class'=>'form-control'] ) !!}
                 </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                   {!! Form::label('file_format','Save As Format') !!}
                   {!! Form::select('file_format',['xlsx'=>'xlsx','xlsm'=>'xlsm','csv'=>'csv'],null,['class'=>'form-control'] ) !!}
                 </div>
              </div>
            </div> 
            {!! Form::hidden('quality_export_list') !!}
            <div class="col-md-12 plr-30">
                <select multiple="multiple" size="10" id="quality-options" name="quality-options">
                    @foreach( $quality_list as $listkey => $listvalue)
                       <option value="{{ $listkey }}">{{ $listvalue }}</option>
                    @endforeach   
                </select>
           </div>
        </div>  
       	<div class="modal-footer">
             <button type="button" class="btn btn-info btn-basic-shadow pull-right get-values">Export</button>
           {!! Form::close(); !!}
      	</div>
    </div>
  </div>
</div>


@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('#export-excel').click(function() {
			 $('#export-baby').modal('show');
		});

        new DualListbox("#quality-options", {
            availableTitle: "Available numbers",
            selectedTitle: "Selected numbers",
            addButtonText: ">",
            removeButtonText: "<",
            addAllButtonText: ">>",
            removeAllButtonText: "<<",
            searchPlaceholder: "search numbers",
            enableDoubleClick: true,
        });

        $('.moveall i').removeClass().addClass('fa fa-arrow-right');
		$('.removeall i').removeClass().addClass('fa fa-arrow-left');
		$('.move i').removeClass().addClass('fa fa-arrow-right');
		$('.remove i').removeClass().addClass('fa fa-arrow-left');

		$('.get-values').click(function() {

	        var value_list = [];
	        $('.dual-listbox__selected li').each(function(){
	            value_list.push($(this).attr('data-id'));
	        });

	        var validate   = false;
	        $('.error-export').remove();
			$('input[name="quality_export_list"]').val(JSON.stringify(value_list));
	      	if ($('input[name="file_name"]').val() == '') {
	         	validate = true;
	         	$('input[name="file_name"]').after('<span class="error-export"> This fields required</span>');
	       	} 
        	if (value_list.length == 0) {
	           	validate = true;
	            $('select[name="quality-options_helper2"]').after('<span class="error-export"> Please Choose The Fields required</span>');
	      	}
	      	if (!validate) {
	           	$('#export-sheet').submit();
	           	$('#export-baby').modal('hide');
	      	}

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
