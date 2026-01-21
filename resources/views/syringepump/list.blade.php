@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Syringepump\SyrangePumpController@index') }}">Syringe Pump</a></li>        
        <li class="current"><a>Create</a></li>                                                
    </ul>
</div>

<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
        <div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Syringe Pump</h4>
					<a href="{{ action('Syringepump\SyrangePumpController@create') }}" title="" class="btn btn-basic-shadow btn-info pull-right create-btn-spacing">
						<i class="fa fa-plus "></i> <span>Create New</span></a>
			</div>
        </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->
@endsection
