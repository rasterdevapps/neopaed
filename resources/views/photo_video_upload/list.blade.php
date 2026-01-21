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
			<a href="{{ action('PhotoVideoUploadController@index') }}">Upload</a>
		</li>                                         
	</ul>
</div>
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Upload</h4>        
				<a href="{{ action('PhotoVideoUploadController@create') }}" title="Create New" class="btn create-btn-spacing btn-basic-shadow btn-info pull-right">
					<i class="fa fa-plus"></i>
					<span>Create New</span>
				</a>   
			</div>
			<div class="widget-content inherittable">                    
			    <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
			         <thead>
			            <tr>
			              	<th>S.No.</th>
			              	<th>{{ Lang::get('home.mrn') }}</th>
			              	<th>Baby Name</th>
			              	<th>Mother Name</th>
			              	<th>Description</th>
			              	<th>Created Date</th>
			            </tr>
			        </thead>
			        <tbody>
			        	@if(count($uploads) > 0)
			                @php $i = 1 @endphp
			                @foreach($uploads as $upload)
					        	<tr>
					        		<td>{{ $i }}</td>
					        		<td><a href="{{ action('PhotoVideoUploadController@edit',$upload->Id) }}">{{ $upload->BMrNo }}</a></td>
					        		<td>{{ $upload->BabyName }}</td>
					        		<td>{{ $upload->BMrNo }}</td>
					        		<td>{{ $upload->description }}</td>
					        		<td>{{ date('d-m-Y', strtotime($upload->created_at)) }}</td>
					        	</tr>
					        	@php $i = $i+1 @endphp
					        @endforeach
					    @else 
					    	<tr class="text-center">
			                  	<td colspan="6">No Record Found</td>
			                </tr>
						@endif
			        </tbody>
			    </table>   
	      	</div>
	    </div>
    </div> 
</div>
@endsection
