@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<style type="text/css">
	.border-radius-5 {
		border-radius: 5px !important;
	}
</style>
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li class="current">
			<a href="{{ action('Fhir\FhirFormattedValuesController@monitordata') }}">Monitor Values</a>
		</li>                                         
	</ul>
</div>
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Monitor Values</h4> 
			</div>
			<div class="widget-content">
				<div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
					<div class="row">
						<div class="dataTables_header clearfix">
							<div class="col-xs-4 col-sm-6 col-md-6">
								<div id="data-list_length" class="dataTables_length">
									<label class="data_limit">
										{{ Form::open(['url' => action('Fhir\FhirFormattedValuesController@monitordata'), 'method' => 'get', 'id' => 'limit-form']) }}
										<select name="limit"  size="1" aria-controls="data-list">
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
							<div class="col-xs-8 col-sm-6 col-md-6">
								<!-- <span class="text-center error-message pull-right"><b><i class="fa fa-info-circle bs-tooltip" style="color: black;"></i>&nbspPlease, use any one of the field for data filter</b></span> -->
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 mt-15 mb-20 p-10 multi-search display-grid" style="border: 1px solid #dddddd; float: unset;">
					{{ Form::model($search, ['url' => action('Fhir\FhirFormattedValuesController@monitordata'), 'method' => 'get', 'id' => 'filter-monitor']) }}
					<div class="col-md-2">
						<div class="form-group">
							{!! Form::label('mrno', Lang::get('home.mrn').':', ['class'=>'required-label']) !!}
							{!! Form::text('mrno',null,['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							{!! Form::label('ipnumber', Lang::get('home.ip') .':') !!}
							{!! Form::text('ipnumber',null,['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							{!! Form::label('devicename','Device Name:') !!}
							{!! Form::select('devicename',['N/A'=>'N/A','MINDRAY_N-SERIES'=>'MINDRAY_N-SERIES', 'MONITOR'=>'MONITOR'],null,['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							{!! Form::label('receivetime','Received Time:') !!}
							{!! Form::text('receivetime',null,['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							{!! Form::label('low','Low:') !!}
							{!! Form::number('low',null,['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							{!! Form::label('firstquartile','First Quartile:') !!}
							{!! Form::number('firstquartile',null,['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							{!! Form::label('mean','Mean:') !!}
							{!! Form::text('mean',null,['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							{!! Form::label('lastquartile','Last Quartile:') !!}
							{!! Form::number('lastquartile',null,['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							{!! Form::label('close','Close:') !!}
							{!! Form::number('close',null,['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="col-md-2" style="display: flex;flex-direction: row;justify-content: center;align-items: center;height: 70px;">
						<button class="btn btn-primary save-button-shadow monitor-data-filter mr-10"> Search </button>
						<button class="btn btn-default save-button-shadow reset ml-10">Reset</button>
					</div>
					{{ Form::close() }}
				</div>
				@if(isset($search['mrno']) && !empty($search['mrno']))
				@if(count($lists) > 0)
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center pb-5" style="background-color: #00ff4e38;">
					@php $details = collect($lists)->first(); @endphp
					<h3><strong>{{ $details->name }} - {{ $details->mrn }} ( {{ $details->ip_number }} {{ isset($details->birthdate) ?  '/ ' . date('d-m-Y', strtotime($details->birthdate)) : '' }} )</strong></h3>
				</div>
				@endif
				<table class="table table-striped table-bordered table-responsive" id="data-list">
					<thead>
						<tr>
							<th class="hidden-xs">S.No.</th>
							<th class="sorting_by sorting_icon @if($order['sortby'] == 'issued') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('issued') }}">Received Date & Time</th>
							<th class="sorting_by sorting_icon @if($order['sortby'] == 'local_description') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('local_description') }}">Description</th>
							<th class="sorting_by sorting_icon @if($order['sortby'] == 'model') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('model') }}">Device Name</th>
							<th class="sorting_by sorting_icon @if($order['sortby'] == 'low') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('low') }}">Low</th>
							<th class="sorting_by sorting_icon @if($order['sortby'] == 'first_quartile') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('first_quartile') }}">Open</th>
							<th class="sorting_by sorting_icon @if($order['sortby'] == 'mean') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('mean') }}">Mid</th>
							<th class="sorting_by sorting_icon @if($order['sortby'] == 'close') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('close') }}">Close</th>
							<th class="sorting_by sorting_icon @if($order['sortby'] == 'last_quartile') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('last_quartile') }}">High</th>
						</tr>
					</thead>
					<tbody>
						@if(count($lists) > 0)
						@php 
						$i = $pagination['limit'][0] - 1;
						@endphp
						@foreach($lists as $list_key => $list)   
						<tr class="detailinfo">
							<td class="hidden-xs">{{ $i+1 }}</td>                    
							<td><a href="{{ url('fhir-format-value'.'/'.SiteHelpers::encrypt_id($list->moniter_id)) }}/monitor:{{$list->status}}">{{ date('d-m-Y H:i',strtotime($list->issued)) }}</a></td>                    
							<td>{{ $list->local_description }}</td>
							<td>{{ $list->model }}</td>
							<td>{{ number_format($list->low, 2) }}</td>
							<td>{{ number_format($list->first_quartile, 2) }}</td>
							<td>{{ number_format($list->mean, 2) }}</td>
							<td>{{ number_format($list->close, 2) }}</td>
							<td>{{ number_format($list->last_quartile, 2) }}</td>
						</tr>                
						@php $i = $i+1 @endphp 
						@endforeach
						@else 
						<tr class="border-bottom">
							<th colspan="9" class="text-center">No record found</th>
						</tr>
						@endif
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12">
						<div class="dataTables_footer clearfix">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
									Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries {{ @$getTotal != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="dataTables_paginate paging_bootstrap pagination_footer">
									<ul class="pagination">
										<?php
										$query_string_operator = '';
										if(Request::has('mrno') || Request::has('search_txt'))
										{
											$query_string_operator = '&';
										}
										else
										{
											$query_string_operator = '';
										}
										$current_url = url('/monitor-values/');

										if(Request::has('page'))
										{
											$current_url = $current_url.'?'.http_build_query(Request::except('page'));
										}
										else
										{
											$current_url = $current_url.'?'.http_build_query(Request::query());
										}
										?>
										<li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">

											<a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ $current_url }}{{ $query_string_operator }}page={{ $pagination['previous'] }} @endif">&#8592; Previous</a>
										</li>
										@for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
										<li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
											<a class='sort_with_page' href="{{ $current_url }}{{ $query_string_operator }}page={{ $i }}">{{$i}}</a>
										</li>  
										@endfor
										<li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
											<a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ $current_url }}{{ $query_string_operator }}page={{ $pagination['next'] }} @endif">Next &#8594; </a>  
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif               
			</div> 
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {

		$(".monitor-data-filter").on("click", function() {
			$("#filter-monitor").validate({
				rules:{
					mrno:{
						required: true
					}
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
			var sorting_param  = $('#limit-form').serialize();
			var searchinput  = $('#filter-monitor').serialize();

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
				window.location = pagination_url + '?page=1&limit=' + limit + '&' + searchinput + '&sortby=' + sortby + '&sortorder=' + sortorder;
			} else {
				window.location = pagination_url + '?page=1&' + searchinput + '&' + sorting_param;
			}

		}
		$('.reset').click(function() {
			var form = $('#filter-monitor').get(0);
			$.removeData(form,'validator');

			$('input, select').val('');
		});     
	});
	$('#dob').datepicker({
		dateFormat: 'dd-mm-yy',
		yearRange: "-60:+02",
		changeMonth : true,
		changeYear : true,
		maxDate : '+0M',

	});
</script>
@endsection
