@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
	<div class="crumbs bread-crumbs-shadow">
		<ul id="breadcrumbs" class="breadcrumb">
			<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
			<li class="current"><a href="javascript:void(0);">Recorder History</a></li>                                                
		</ul>					
	</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
        <div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Recorder History</h4>                        
			</div>
            <div class="widget-content no-padding">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                        {!! Form::open(['url' => action('Audio\AudioFileController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                                            <select name="limit"  size="1" aria-controls="data-list" onchange="form.submit();">
                                                <option value="10"   @if(isset($pagination['limits']) && $pagination['limits'] == 10) selected="selected" @endif  >10</option>
                                                <option value="25"   @if(isset($pagination['limits']) && $pagination['limits'] == 25) selected="selected" @endif>25</option>
                                                <option value="50"   @if(isset($pagination['limits']) && $pagination['limits'] == 50) selected="selected" @endif>50</option>
                                                <option value="100"  @if(isset($pagination['limits']) && $pagination['limits'] == 100) selected="selected" @endif>100</option>
                                                <option value="1000" @if(isset($pagination['limits']) && $pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                            </select>

                                         <span class="hidden-xs">records per page </span>
                                      {!! Form::close() !!}
                                    </label>
                                </div>
                                </div>
                            {!! Form::open(['url' => action('Audio\AudioFileController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                            <div class="col-md-6">
                                <a href="{{ action('Audio\AudioFileController@index') }}" class="btn btn-sm search-reset">
                                    <i class="fa fa-remove"></i>
                                </a>
                                <div class="dataTables_filter" id="data-list_filter">
                                    <label>
                                        <div class="input-group">
                                            <span id="search" class="input-group-addon">
                                                <i class="fa fa-search"></i>
                                            </span>
                                            <input type="text" aria-controls="data-list" name="search_txt" value="{{ @$search['search_txt'] }}" placeholder="Search" class="form-control">
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
                            <th data-hide="phone,tablet">Date of birth</th>
                        </tr>
                    </thead>
                    <tbody>
                	@foreach ($results as $result)
                        <tr>
                            <td><a href="{{ action('Audio\AudioFileController@getModuleList', $result->BabyId) }}">{{  $result->BabyName }}</a></td>
                            <td>{{  $result->BMrNo }}</td>
                            <td>{{  (date('Y',strtotime($result->DOB)) > 1970) ? date('d-m-Y',strtotime($result->DOB)) : ''  }}</td>
                        </tr>
                	@endforeach
                    </tbody>
				</table>  
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
                                        <a class="sort_with_page" href="{{url('audio-file-list?page='.$pagination['previous'])}}">← Previous</a>
                                    </li>
                                    @for ($i = $pagination['start']; $i <= $pagination['end']; $i++)
                                     <li @if($i == Request::query('page'))class="active"@endif;>
                                        <a  class="sort_with_page" href="{{url('audio-file-list?page='.$i)}}">{{$i}}</a>
                                     </li>
                                    @endfor
                                    <li class="next  @if($pagination['next'] == $pagination['end']) disabled  @endif">
                                       <a  class="sort_with_page" href="{{url('audio-file-list?page='.$pagination['next'])}}">Next → </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                       </div>
                  </div>
              </div><!-- /.row -->    
            </div>
        </div>
	</div> <!-- /.col-md-12 -->
</div>
<!-- /.row -->            
@endsection
@section('scripts')

@endsection	
