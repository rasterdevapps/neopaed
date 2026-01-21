@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
@php $hide=true ; @endphp
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li class="current">
			<a href="{{ action('Admission\PostnatalDaycareController@index') }}">Postnatal Daycare</a>
		</li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Daycare</h4>
                @include('admission_filter')
                @if(in_array('POST_DAY',$write_permission))
				<a href="{{ action('Admission\PostnatalDaycareController@create') }}" title="Create New" class="btn btn-basic-shadow btn-info pull-right create-btn-spacing create-btn">
				<i class="fa fa-plus "></i>
				 <span>Create New</span>
				 </a>  
                @endif                              
			</div>
			<div class="widget-content">    
				<div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          <div class="row">
            <div class="dataTables_header clearfix">
              <div class="col-xs-4 col-sm-6 col-md-6">
                <div id="data-list_length" class="dataTables_length">
                  <label class="data_limit">
                {!! Form::open(['url' => action('Admission\PostnatalDaycareController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                    <select name="limit"  size="1" aria-controls="data-list">
                      <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                      <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                      <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                      <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                      <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                    </select>
                    {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                    {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}<span class="hidden-xs">records per page</span>{!! Form::close() !!}
                  </label>
                </div>
              </div>
              {!! Form::open(['url' => action('Admission\PostnatalDaycareController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!}               
              <div class="col-xs-8 col-sm-4 col-md-4 pull-right">  
                <div class="input-group">
                  <span id="search" class="input-group-addon">
                    <i class="glyphicon glyphicon-search"></i>
                  </span>
                  <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ $search['search_txt'] }}" placeholder="Search">
                     <a href="{{ action('Admission\PostnatalDaycareController@index')}}" class="input-group-addon" id="search-reset"><i class="glyphicon glyphicon-remove"></i></a>
                </div>                            
                {!! Form::close() !!}
              </div> 
            </div>
          </div>
		      <table class="table table-striped table-bordered table-responsive"  id="data-list">
            <thead>
              <tr>
                <th>S.No.</th>
                <th class="sorting_by sorting_icon @if($order['sortby'] == 'baby.BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('baby.BabyName') }}">BabyName</th>
                <th class="sorting_by sorting_icon @if($order['sortby'] == 'baby.BMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('baby.BMrNo') }}">{{ Lang::get('home.mrn') }}</th>
                <th class="sorting_by sorting_icon @if($order['sortby'] == 'baby.DOB') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('baby.DOB') }}" data-hide="tablet,phone">DOB</th>
                @if($hide==false)
                  @if(in_array('POST_DAY',$write_permission))
                  <th >Edit</th>  
                  <th >Delete</th>                            
                  @endif   
                  <th>Preview</th>
                  <th>Print</th> 
                @endif  
              </tr>
            </thead>
            <tbody>
            @if(count($results) > 0 )  
              @for ($i = 0; $i <  @count($results); $i++)
                <tr>
                  <td>{{ $i+1 }}</td>
                  <td>
                    <a href="{{ action('Admission\PostnatalDaycareController@postnatalSublist',SiteHelpers::encrypt_id($results[$i]->BabyId ))}}">
                      {{  $results[$i]->BabyName }}
                    </a>
                  </td>
                  <td>{{  $results[$i]->BMrNo }}</td>
                  <td>@if(date('Y',strtotime($results[$i]->DOB)) > 1970) {{ date('d-m-Y',strtotime($results[$i]->DOB)) }} @endif</td>
                  @if($hide==false)
                  @if(in_array('POST_DAY',$write_permission))
                   <td  class="center-align-phone"><a class="icon" href="{{ action('Admission\PostnatalDaycareController@edit', $results[$i]->PDayId) }}"><i class="fa fa-pencil"></i> <span class="hidden-phone">Edit</span></a></td>
                   <td  class="center-align-phone"><a class="icon" href="javascript:void(0);" onclick="DeleteData({{ $results[$i]->PDayId }})"><i class="fa fa-remove"></i> <span class="hidden-phone">Delete</span></a></td>
                  @endif
                    <td  class="center-align-phone"><a class="icon" onclick="ShowModal({!!  $results[$i]->PDayId !!},'{{ action('Admission\PostnatalDaycareController@getData',$results[$i]->PDayId) }}')" href="javascript:void(0);"><i class="fa fa-eye"></i> <span class="hidden-phone">View</span></a></td>          
                    <td  class="center-align-phone"><a class="icon" href="{{ action('Admission\PostnatalDaycareController@printData',$results[$i]->PDayId) }}"><i class="fa fa-print"></i> <span class="hidden-phone">Print</span></a></td>                                
                  @endif
                </tr>
              @endfor
            @else
                <tr class="text-center"><td colspan="4">No Record Found </td></tr>  
            @endif  
            </tbody>
            </table>
              <div class="row">
                <div class="col-md-12">
                  <div class="dataTables_footer clearfix">
                    <div class="col-md-6 col-sm-6 col-xs-12 pagination-xs">
                      <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                        Showing {{$pagination['limit'][0]}} to {{$pagination['limit'][1]}} of {{$pagination['total']}} entries {{ $search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                      </div>
                    </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 pagination-xs">
                        <div class="dataTables_paginate paging_bootstrap pagination_footer">
                          <ul class="pagination">    
                            <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                              <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('postnatal-daycare?page='.$pagination['previous']) }}@endif">&#8592; Previous</a>
                            </li>
                          @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                            <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                              <a class='sort_with_page' href="{{ url('postnatal-daycare?page='.$i) }}">{{$i}}</a>
                            </li>  
                          @endfor
                            <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                              <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('postnatal-daycare?page='.$pagination['next']) }}@endif">Next &#8594; </a>  
                            </li>
                          </ul>
                        </div>
                      </div>
                  </div>
                </div>
              </div>  
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
function ShowModal(id,url1){
	  $.ajax({
			  type    :"GET",
			  url     : url1,
			  data    :{ id:id },
			  success :function(response){
				  Datas = JSON.parse(response);
				  EditLink = '';
				  @if(in_array('POST_DAY',$write_permission))
				  EditLink = '<a href="/postnatal-daycare/'+Datas['PDayId']+'/edit" class=""><i class="fa fa-pencil"></i></a>';
				  @endif
				 PrintLink = '<a href="/postnatal-daycare/'+Datas['PDayId']+'/printdata" class=""><i class="fa fa-print"></i></a>';
				  $(".modal-title").html(Datas['BabyName']+' '+EditLink + ' '+PrintLink);						  			  
				 
				  $(".col-name").html(Datas['BabyName']);
				  $(".col-bmrno").html(Datas['BMrNo']);
				  $(".col-sex").html(Datas['Sex']);			  				  				  				
				  $(".col-birthweight").html(Datas['BirthWeight']);				  				  				  				
				  $(".col-dob").html(Datas['DOB']);				  				  				  								 				

				  $(".col-dayoflife").html(Datas['DayOfLife']);				  				  				  				
  								  
				  $(".col-date").html(Datas['DayDate']);				  				  				  				
				  $(".col-time").html(Datas['DayTime']);				  				  				  				 				

				  $(".col-currentprobs").html(Datas['CurrentProblems']);				  				  				  								  				   								  
				  $(".col-previousprobs").html(Datas['PreviousProblems']);
				  $(".col-background").html(Datas['Background']);				  				  				  				
				  
				  },
			  complete: function(){
			  	$('#basicModal').modal('show');
			  }
		});
}
function DeleteData(id){
	  bootbox.confirm("Are you sure?",function(confirmed){
		  if(confirmed){
			  $("#DeleteForm").attr('action',"{{ action('Admission\PostnatalDaycareController@index') }}/"+id);
			  $("#DeleteForm").submit();
		  }
	  });
}
// $( "#search" ).click(function() {
//     $( "#search-form" ).submit();
// });


// $('.sorting_by').on('click', function(e) {
//     e.preventDefault();
//     var sortby       = $(this).data('field');
//     pagination(sortby);
// });

// $('.sort_with_page').click(function(e){
//     e.preventDefault();
//     var sorting_param = $('#limit-form').serialize();
//     var link      = $(this).attr('href');
//     var searchText    = $('input[name="search_txt"]').val();
//     window.location   = link + '&search_txt=' + searchText + '&' + sorting_param;
// });

// $('select[name="limit"]').on('change',function(e) {
//     e.preventDefault();
//     pagination();
// });

// function pagination(sortby) {
//   var pagination_url = $('#limit-form').attr('action');
//   var limit          = $('select[name="limit"] option:selected').val();
//   var searchText     = $('input[name="search_txt"]').val();    
//   var sorting_param  = $('#limit-form').serialize();
//   var sorting_param1 = sorting_param.split('&sortorder=')[0];
//   var sorting_param2 = sorting_param.split('&sortorder=')[1];

//   if (sortby) {
//     $('#sortby').val(sortby);
//     if (sorting_param2 == 'desc') {
//       var sortorder = 'asc';
//       $('#sortorder').val(sortorder);
//     } else {
//       var sortorder = 'desc';
//       $('#sortorder').val(sortorder);
//     }
//     window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
//   } else {
//     window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
//   }

// }
</script>
@endsection
