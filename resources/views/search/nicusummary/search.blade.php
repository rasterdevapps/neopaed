@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }} ">Dashboard</a></li>
		<li class="@if($search_status != 'true') current @endif"><a href="{{ action('Reports\NicuDischargeController@DischargeSummarySearch') }}">NICU Discharge Summary Search</a></li> 
		@if($search_status == 'true')
		<li class="current current-baby-name">{{ $baby_name }}</li>  
		@endif                                             
	</ul>
	<ul class="pull-right" style="list-style: none;">
		<li style="margin: 3px 8px !important;"><a href="{{ action('Reports\NicuDischargeController@DischargeSummarySearch') }}" class="btn btn-info btn-basic-shadow"> Reset</a></li>
	</ul>
	@if(count($list_details) > 0)
	<ul class="pull-right" style="list-style: none;">
		<li style="margin: 8px -24px !important;"><span>No. Of Record : {{ count($list_details) }}  </span></li>
	</ul>
	@endif
</div>
<!-- /Breadcrumbs line -->
<div class="row  @if($search_status == 'true') hide @endif">
	{!! Form::model($list_details,['method' => 'GET','url' => action('Reports\NicuDischargeController@DischargeSummarySearch')]) !!}
	<div class="col-md-9">
		<span class="search-query"></span>
	</div>
	<div class="col-md-9">
		<table class="table search-table">
			<thead>	
				<tr>
					<th>Condition</th>
					<th>
						{!! Form::label('advanced_search', ' Search:') !!} 	
					</th>
					<th></th>
				</tr> 	
			</thead>
			<tbody>
				<tr>
					<td></td>	
					<td>
						{!! Form::text('advanced_search[]',$search_txt,['class'=>'form-control', 'placeholder'=>'Please enter the text here !']) !!}
					</td>
					<td>
						<a href="javascript:void(0);" type="button" class="btn add-search"> 
							<i class="fa fa-plus-circle" aria-hidden="true"></i> 
						</a>
					</td>
				</tr>
			</tbody>    
		</table>
	</div>
	<div class="col-md-9">
		<div class="pull-right">
			<button type="submit" class="btn btn-basic-shadow btn-info"> Search</button>
		</div>
	</div>
	{!! Form::close() !!}
</div>
<!--=== Page Content ===-->
@if($search_status == 'true')
<div class="row row-spacing">
	<div class="col-md-9">
		<h3 style="text-align: center;"> Your Search For " {{ $search_txt }} "</h3>
		<iframe class="col-md-12" id="nicu-summary-report"></iframe>
	</div>
	<div class="col-md-3 custom-fields-search-list-sidebar summary-search-sidebar">   
		<table class="table table-striped table-bordered  table-responsive"  id="data-list">
			<thead>
				<tr class="hide">
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@if(isset($list_details) && count($list_details) > 0)
				<tr>
					<td>
						@for ($i = 0; $i <  @count($list_details); $i++)
						<div class="fields-search-list baby-admission-list @if($i == 0) search-list-active @endif">
							<a class="summary-list" href="{{ url('nicu-discharge-summary/'.SiteHelpers::encrypt_id($list_details[$i]->baby_id.'-'.$list_details[$i]->admission_id))}}">
								{{  $list_details[$i]->BabyName.'-'.$list_details[$i]->BMrNo }}
							</a>
						</div>
						@endfor
					</td>
				</tr>
				@else
				<tr>
					<td>
						<div class="text-center"> No Records Found </div>
					</td>
				</tr>
				@endif   
			</tbody>
		</table>
		<?php 
		$page = isset($page) ? $page : 1;
		if (isset($list_details)) {
			$getTotal = count($list_details);
			$total = $getTotal;
			$limit = 10;
			$pagecount = ceil($total / $limit);
			$pagination['total'] = $total;
			$pagination['start'] = (($page - 2) < 1) ? 1 : ($page - 2);
			$pagination['end'] = ($pagecount < ($page + 3)) ? $pagecount : ($page + 3);
			$pagestart = $total != 0 ? ($page <= 1) ? $page : ($page - 1) * $limit + 1 : 0;
			$pagerecords = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page * $limit;
			$pagination['limit'] = array(
				$pagestart,
				$pagerecords
			);
			$pagination['limits'] = $limit;
			$pagination['previous'] = (($page - 1) < 1) ? 1 : ($page - 1);
			$pagination['next'] = ($pagecount < ($page + 1)) ? $pagecount : ($page + 1);
		}
		?>
		<div class="dataTables_footer clearfix">
			<div class="col-md-12 col-sm-12 col-xs-12 pagination-xs">
				<div class="dataTables_paginate paging_bootstrap pagination_footer">
					<ul class="pagination">
						<li class="prev @if($page == '' || $page == @$pagination['start']) disabled @endif">
							<a class="@if($page != @$pagination['start'] &&  $page != '') sort_with_page @endif" href="@if($page == @$pagination['start'] || $page == '') javascript:void(0); @else {{url('nicu-advance-search?page='.@$pagination['previous'])}}@endif">&#8592; {{ Lang::get('home.neonatal_previous') }}</a>
						</li>
						@if (@$getTotal > 0)
						@for ($i = @$pagination['start']; $i <= @$pagination['end']; $i++) 
						<li class="@if($i == $page) active @elseif($page == '' && $i == @$pagination['start']) active @endif">
							<a class='sort_with_page' href="{{url('nicu-advance-search?page='.$i)}}">{{$i}}</a>
						</li>
						@endfor
						@endif
						<li class="next @if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) disabled @endif">
							<a class="@if($page != @$pagination['end'] && @$pagination['start'] != @$pagination['end']) sort_with_page @endif" href="@if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) javascript:void(0); @else {{url('nicu-advance-search?page='.@$pagination['next'])}}@endif">{{ Lang::get('home.neonatal_next') }} → </a>  
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div> 
@endif
@endsection
@section('scripts')
<script type="text/javascript">

	@if($search_status == 'true')

	$(document).ready(function() {
		var windowHeight = $(window).height();
		$("#nicu-summary-report").css('height',windowHeight-150+'px');
		$('.summary-list').first().trigger('click');

	});

	$('.summary-list').click(function(e) {
		e.preventDefault();

		$('.baby-admission-list').removeClass('search-list-active');
		$(this).parent().addClass('search-list-active');
		var url_param =  $(this).attr('href');

		$.ajax({
			type    :"GET",
			url     : url_param,
			success :function(response) {

				var windowHeight = $(window).height();
				var myFrame      = $("#nicu-summary-report").contents().find('body');
				$("#nicu-summary-report").css('height',windowHeight-150+'px');
				console.log(response.discharge_summary);
				myFrame.html(response.discharge_summary);
				$('.current-baby-name').text(response.babyName);
				$("#nicu-summary-report").contents().find('.print-tool-bar').hide();
				$("#nicu-summary-report").contents().find('.hidden-print').hide();



			},
			complete: function() {
				Showalert('success','Record Loaded Successfully!');
			},
			error: function() {
				Showalert('info','Unable To Load The Record!');
			}

		});
	});
	@else

	$(document).on('click', '.add-search',function() {

		var buttonFieldAdd  = '<a href="javascript:void(0);" type="button" class="btn add-search"> <i class="fa fa-plus-circle" aria-hidden="true"></i></a>';
		buttonFieldMin  = '<a href="javascript:void(0);" type="button" class="btn remove-search"> <i class="fa fa-minus-circle" aria-hidden="true"></i></a>';

		var searchField     = '<td><input class="form-control" placeholder="Please enter the text here !" name="advanced_search[]" type="text" value=""></td>';
		var	searchOperator  = '<td><select class="form-control" name="search_operator[]"><option value="AND">AND</option><option value="OR">OR</option><option value="NOT">NOT</option></select></td>';

		searchField     = searchOperator+searchField+'<td>'+buttonFieldAdd+buttonFieldMin+'</td>';


		$('.search-table tbody').append('<tr>'+searchField+'</tr>');

		if ($('.search-table tbody tr').length > 1) {
			$('.search-table tbody tr').first().children('td:last').html(buttonFieldMin);
			$('.search-table tbody tr').last().prev('tr').children('td:last').html(buttonFieldMin);

			var isExist = $('.search-table tbody').children('tr:nth-child(2)').children('td').length;

		} else{
			$('.search-table tbody tr').first().children('td:last').html(buttonFieldAdd);

		}

	});

	$(document).on('click', '.remove-search',function() {
		var buttonFieldAdd  = '<a href="javascript:void(0);" type="button" class="btn add-search"> <i class="fa fa-plus-circle" aria-hidden="true"></i></a>';
		buttonFieldMin  = '<a href="javascript:void(0);" type="button" class="btn remove-search"> <i class="fa fa-minus-circle" aria-hidden="true"></i></a>';

		$(this).parent().parent().remove();
		if ($('.search-table tbody tr').length > 1) {
			$('.search-table tbody tr').first().children('td:last').html(buttonFieldMin);
			$('.search-table tbody tr').last().children('td:last').html(buttonFieldAdd+buttonFieldMin);

		} else{
			$('.search-table tbody tr').first().children('td:last').html(buttonFieldAdd);

		}

		var	firstChildLength = $('.search-table tbody tr').first().children('td').length;

		if (firstChildLength == 3 ) {
			$('.search-table tbody tr').first().children('td:first').html('');
		}
	});

	@endif
	
</script>
@endsection
