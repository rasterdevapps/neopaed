@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<style type="text/css">
	.pagination-list .pagination {
	    margin: 0;
	}
</style>
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Fhir\FhirFormattedValuesController@index') }}">Fhir Formatted Value</a>
		</li>                                         
	</ul>
</div>
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Fhir Formatted Value</h4> 
			</div>
      		<div class="widget-content">
        		<div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          			<div class="row">
           				<div class="dataTables_header clearfix">
			              	<div class="col-xs-4 col-sm-6 col-md-6">
				                <div id="data-list_length" class="dataTables_length">
				                  <label class="data_limit">
				                      	{{ Form::open(['url' => action('Fhir\FhirFormattedValuesController@hour_wise_list',$id), 'method' => 'get', 'id' => 'limit-form']) }}
						                    <select name="limit"  size="1" aria-controls="data-list" onchange="form.submit();">
						                        <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif>10</option>
						                        <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
						                        <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
						                        <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
						                        <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
						                    </select><span class="hidden-xs">records per page</span>
						                    {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                        	{!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
				                      	{{ Form::close() }}
				                  </label>
				                </div>
			              	</div>
				            {{ Form::open(['url' => action('Fhir\FhirFormattedValuesController@hour_wise_list',$id), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) }}
				            <div class="col-xs-8 col-sm-6 col-md-4 pull-right"> 
				                <div class="input-group">
				                    <span id="search" class="input-group-addon">
				                      	<i class="glyphicon glyphicon-search"></i>
				                    </span>
				                    <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ $search_txt }}" placeholder="Search"  class="form-control">
				                    <a href="{{ action('Fhir\FhirFormattedValuesController@hour_wise_list',$id) }}" class="input-group-addon">
				                      	<i class="glyphicon glyphicon-remove"></i>
				                    </a>
				                </div>   
				            </div>
				            {{ Form::close() }}
                		</div>
            		</div>
        		</div>
		    	<table class="table table-striped table-bordered table-responsive" id="data-list">
		    	  	<thead>
		            	<tr>
		           			<th>S.No.</th>
				            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('mrn') }}">{{ Lang::get('home.mrn') }}</th>
				            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('date') }}">Date</th>
				            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('birthdate') }}">DOB</th>
				            <th class="sorting_by sorting_icon" data-field="{{ SiteHelpers::encrypt_id('ip_number') }}">{{ Lang::get('home.ip') }}</th>
			            </tr>
			        </thead>
		          	<tbody>
		          	@if(count($lists) > 0)
		                @php $i = 0 @endphp     
		                @foreach($lists as $list)  
		                    <tr class="detailinfo">
		                    	<td>{{ $i+1 }}</td>                    
		                    	<td><a href="{{ action('Fhir\FhirFormattedValuesController@show_fhir',['mrn' => $list->mrn, 'issued' => $list->issued]) }}">{{ date('d-m-Y', strtotime($list->issued)) }}</a></td>                    
		                    	<td>{{ $list->name }}</td>
		                    	<td>{{ date('d-m-Y', strtotime($list->birthdate)) }}</td>
		                    	<td>{{ $list->ip_number }}</td>
		                    </tr>                
		                    @php $i = $i+1 @endphp 
		                @endforeach
		            @else 
		                <tr class="border-bottom">
		                    <th colspan="5" class="center padding">No record found</th>
		                </tr>
		            @endif
		          	</tbody>
		    	</table>
		    	<div class="row pagination-list mt-15">
	                <div class="col-md-12 p-0">
	                	<div class="col-md-6 mtb-5"><span class="text-vertical-middle">Showing 1 to {{ $pagination['limits'] }} of {{ count($lists) }} entries</span></div>
	                	<div class="col-md-6"><span class="pull-right"></span></div>
	                </div>
	            </div>                
	    	</div> 
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('.sorting_by').on('click',function(e) {    
            e.preventDefault();
            $('#sortby').val($(this).data('field'));
            if($('#sortorder').val()=='desc') {
              $('#sortorder').val('asc');
            } else {
              $('#sortorder').val('desc');
            }
            $('#limit-form').submit();
        });                
	});
</script>
@endsection
