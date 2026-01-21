@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('ProblemBaseDaycare\ProblemSettingController@index') }}">Problem Settings</a></li>       
		<li class="current"><a>Create</a></li>                                                 
	</ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row">
	<div class="col-md-12">
	</div>
</div>		



@endsection
