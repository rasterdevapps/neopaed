@extends('app')
@section('content')
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li class="current">
			<a href="{{ url('/site-settings') }}">Site Settings</a>
		</li> 
		<li>
			<a href="javascript://">Create</a>
	    </li>                                               
	</ul>
</div>
<!-- /Breadcrumbs line -->

<!-- Page Header -->
<div class="page-header">
<!-- <div class="page-title">
		<h3>Dashboard</h3>
	</div>-->
</div>
<!-- /Page Header -->

<!--=== Page Content ===-->
<div class="row">
    <div class="col-md-12">
        <div role="tabpanel" class="tabbable tabbable-custom">
	        <ul class="nav nav-tabs" role="tablist">
	            <li role="presentation" class="active">
	                <a href="#basic-details" aria-controls="babyform" role="tab" data-toggle="tab">Basic Details</a>
	            </li>
	             <li role="presentation" class="">
	                <a href="#reportslogo" aria-controls="babyform" role="tab" data-toggle="tab">Reports Logo</a>
	            </li>
	        </ul>   
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="basic-details">
                   <div class="col-md-12">
	                  <div id='ids'>
	                  </div>
		              <div id="report-logo">
		              </div>
	               </div>
                 </div>
                 <div role="tabpanel" class="tab-pane" id="reportslogo">
                   
                 </div>
               
            </div>
        </div>
    </div>
    
</div>    
<script type="text/javascript">
$(document).ready(function(){
	CKEDITOR.replace( 'ids' );
});

</script>
@endsection
