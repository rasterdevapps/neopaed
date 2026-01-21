@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('Fhir\FhirJsonSchemaController@index') }}">Fihr Json Schema</a>
		</li>                                         
	</ul>
</div>
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Fihr Json Schema</h4> 
			</div>
      		<div class="widget-content">
        		<div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          			<div class="row">
           				<div class="dataTables_header clearfix">
			              	<div class="col-xs-4 col-sm-6 col-md-6">
				                <div id="data-list_length" class="dataTables_length">
				                  <label class="data_limit">
				                      	{!! Form::open(['url' => action('Fhir\FhirJsonSchemaController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
					                     <select name="limit"  size="1" aria-controls="data-list" onchange="form.submit();">
					                        <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
					                        <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
					                        <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
					                        <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
					                        <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
					                     </select><span class="hidden-xs">records per page</span>
				                      	{!! Form::close() !!}
				                  </label>
				                </div>
			              	</div>
				            {!! Form::open(['url' => action('Fhir\FhirJsonSchemaController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!}
				            <div class="col-xs-8 col-sm-6 col-md-4 pull-right"> 
				                 <div class="input-group">
				                    <span id="search" class="input-group-addon">
				                      <i class="glyphicon glyphicon-search"></i>
				                    </span>
				                    <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ $search_txt }}" placeholder="Search"  class="form-control">
				                    <a href="{{ action('Fhir\FhirJsonSchemaController@index') }}" class="input-group-addon">
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
		           			<th>S.No.</th>
				            <th>Resource Type</th>
			            </tr>
			        </thead>
		          	<tbody>
		          	@if(count($lists) > 0)
		                @php $i = 0 @endphp     
		                @foreach($lists as $list)   
		                    <tr class="detailinfo">
		                    	<td>{{ $i+1 }}</td>                    
		                    	<td><a href="{{ action('Fhir\FhirJsonSchemaController@show',$lists[$i]->id) }}">{{ $lists[$i]->resource_type }}</a></td>                    
		                    </tr>                
		                    @php $i = $i+1 @endphp 
		                @endforeach
		            @else 
		                <tr class="border-bottom">
		                    <th colspan="2" class="text-center">No record found</th>
		                </tr>
		            @endif
		          	</tbody>
		    	</table>
		    	<div class="row pagination-list mt-15">
	                <div class="col-md-12 p-0">
	                	<div class="col-md-6 mtb-5"><span class="text-vertical-middle">Showing {{ $lists->currentPage() == 1 ? $lists->currentPage() : ($lists->currentPage() - 1) * $pagination['limits'] + 1 }} to {{ ($lists->currentPage() * $pagination['limits'] > $count) ? $count : ($lists->currentPage() * $pagination['limits'] > $lists->total()) ? $lists->total() : $lists->currentPage() * $pagination['limits'] }} of {{ isset($search_txt) ? $lists->total() : $count }} entries</span></div>
	                	<div class="col-md-6"><span class="pull-right">{{ $lists->links() }}</span></div>
	                </div>
	            </div>                
	    	</div> 
		</div>
	</div>
</div>
@endsection
