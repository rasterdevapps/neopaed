@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li class="current"><a href="{{ action('Extras\CardioController@index') }}">Echocardiography</a></li>        
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Echocardiography</h4>
				@if(in_array('TEST_ECHO',$write_permission))
				<a href="{{ action('Extras\CardioController@create') }}" title="" class="btn btn-basic-shadow btn-info pull-right create-btn-spacing create-btn"><i class="fa fa-plus "></i> <span>Create New</span></a>
				@endif                                
			</div>
			<div class="widget-content"> 
				<div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
					<div class="row">
						<div class="dataTables_header clearfix">
							<div class="col-xs-4 col-sm-6 col-md-6">
								<div id="data-list_length" class="dataTables_length">
									<label class="data_limit">
										{!! Form::open(['url' => action('Extras\CardioController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
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
							{!! Form::open(['url' => action('Extras\CardioController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!}
							<div class="col-xs-8 col-sm-6 col-md-4 pull-right"> 
								<div class="input-group">
									<span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
									<input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ $search_txt or '' }}" placeholder="Search" class="form-control">
									<a href="{{ action('Extras\CardioController@index') }}" class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></a>
								</div>   
							</div>
							{!! Form::close() !!}
						</div>
					</div>          
					<table class="table table-striped table-bordered table-responsive echocardio-datatable dataTable mt-0"  id="data-list">		
						<thead>
							<tr>
								<th> S.No.</th>
								<th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyName') }}"> BabyName</th>
								<th class="sorting_by sorting_icon @if($order['sortby'] == 'BMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BMrNo') }}"> {{ Lang::get('home.mrn') }}</th>
								<th class="sorting_by sorting_icon @if($order['sortby'] == 'DOB') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('DOB') }}"> DOB</th>
								<th class="sorting_by sorting_icon @if($order['sortby'] == 'Outcome') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('Outcome') }}" data-hide="phone,tablet">Outcome</th>
								<th class="sorting_by sorting_icon @if($order['sortby'] == 'TestDate') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('TestDate') }}" data-hide="phone">Date</th>
								<th class="hidden-xs" data-hide="phone">Print</th>                                               
	                            @if(in_array('TEST_ECHO',$delete_permission))
	                            <th class="center-align-phone">Delete</th>                              
	                            @endif
	                        </tr>                        
	                    </thead>
	                    <tbody>
	                    	@if(count($results) > 0)
	                    	@for ($i = 0; $i <  @count($results); $i++)
	                    	<tr>
	                    		<td>{{ $i+1 }}</td>
	                    		<td>
	                    			<a class="icon @if(!in_array('TEST_ECHO',$write_permission)) permission-denied @endif" href="@if(in_array('TEST_ECHO',$write_permission)) {{ action('Extras\CardioController@edit', SiteHelpers::encrypt_id($results[$i]->EchoId)) }} @else javascript:void(0); @endif">
	                    				{{  $results[$i]->BabyName }}
	                    			</a>
	                    		</td>
	                    		<td>{{  $results[$i]->BMrNo }}</td>
	                    		<td>{{ date('d-m-Y',strtotime($results[$i]->DOB)) }}</td>
	                    		<td class="hidden-xs">{{  $results[$i]->Outcome }}</td>
	                    		<td class="hidden-xs">{{  date('d-m-Y',strtotime($results[$i]->TestDate)) }}</td>
	                    		<td class="hidden-xs">
	                    			<a class="btn btn-warning btn-view" href="{{ action('Extras\CardioController@printData', SiteHelpers::encrypt_id($results[$i]->EchoId)) }}">
	                    				<i class="fa fa-print"></i> 
	                    			</a>
	                    		</td>                                  
	                    			@if(in_array('TEST_ECHO',$delete_permission))
	                    		<td class="hidden-xs">
	                    			<a class="btn btn-danger btn-view" href="javascript:void(0);" onclick="DeleteData({{ $results[$i]->EchoId }})">
	                    				<i class="fa fa-trash"></i> 
	                    			</a>
	                    		</td>                                  
	                    			@endif	                                                          
	                    	</tr>
	                    	@endfor
	                    	@else
	                    	<tr><td colspan="8" class="text-center"><span>No Record Found</span> </td></tr>
	                    	@endif   
	                    </tbody>
	                </table> 
	                <div class="row">
	                	<div class="col-md-12">
	                		<div class="dataTables_footer clearfix">
	                			<div class="col-md-6 col-sm-6 col-xs-12">
	                				<div class="dataTables_info  pagination_info" id="DataTables_Table_0_info">
	                					Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries {{ $search_txt != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
	                				</div>
	                			</div>
	                			<div class="col-md-6 col-sm-6 col-xs-12">
	                				<div class="dataTables_paginate paging_bootstrap pagination_footer">
	                					<ul class="pagination">    
	                						<li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
	                							<a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{url('echocardiography?page='.$pagination['previous'])}}@endif">&#8592; Previous</a>
	                						</li>
	                						@for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
	                						<li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
	                							<a class='sort_with_page' href="{{url('echocardiography?page='.$i)}}">{{$i}}</a>
	                						</li>  
	                						@endfor
	                						<li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
	                							<a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{url('echocardiography?page='.$pagination['next'])}}@endif">Next &#8594; </a>  
	                						</li>
	                					</ul>
	                				</div>
	                			</div>
	                		</div>
	                	</div>
	                </div>
				</div>         
            </div><!-- /.row --> 

        </div>
    </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->



<!--
	DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK 
-->      
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}         
@endsection
@section('scripts')
<script type="text/javascript">

	function ShowModal(id,url_param){
		$.ajax({
			type    :"GET",
			url     : url_param,
			data    :{ id:id },
			success :function(response){
				Datas = JSON.parse(response);
				EditLink = '';
				@if(in_array('TEST_ECHO',$write_permission))
				EditLink = '<a href="/echocardiography/'+id+'/edit/" class=""><i class="fa fa-pencil"></i></a>';
				@endif
				PrintLink = '<a href="/echocardiography/'+id+'/printdata/" class=""><i class="fa fa-print"></i></a>';				  
				$(".modal-title").html(Datas['BabyName']+' '+EditLink+ ' '+ PrintLink);				  

				$(".col-name").html(Datas['BabyName']);
				$(".col-bmrno").html(Datas['BMrNo']);
				$(".col-birthweight").html(Datas['BirthWeight']);				  				  				  				
				$(".col-sex").html(Datas['Sex']);
				$(".col-testdate").html(Datas['TestDate']);				  				  				  				
				$(".col-age").html(Datas['Age']);				  				  				  				

				$(".col-echo").html(Datas['EchoBy']);				  				  				  				
				$(".col-outcome").html(Datas['Outcome']);				  				  				  				
				$(".col-dob").html(Datas['DOB']);	
				
				$(".col-findings").html(Datas['Findings']);				  				  				  				 						
				$(".col-impression").html(Datas['Impression']);				  				  				  				
			},
			complete: function(){
				$('#basicModal').modal('show');
			}
		});
	}
	function DeleteData(id){
		bootbox.confirm("Are you sure?",function(confirmed){
			if(confirmed){
				$("#DeleteForm").attr('action',"{{ action('Extras\CardioController@index') }}/"+id);
				$("#DeleteForm").submit();
			}
		});
	}

	$(document).ready(function(){

		console.log($('.dataTable'));

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
