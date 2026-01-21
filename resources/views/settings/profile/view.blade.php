@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li class="current">
			<a href="{{ action('Settings\ProfileController@index') }}">User Profile</a>
		</li>                                                
	</ul>
	
</div>
<!-- /Breadcrumbs line -->

<!-- Page Header -->
<div class="page-header">
	<div class="page-title">
		<h3>User Profile</h3>
		<span>Welcome, {{ $user_detail['name'] }}</span>
	</div>
	<div class="row ">
		<div class="col-md-12">
			@include('errors.list')
		</div>           
	</div>         
</div>
<!-- /Page Header -->
<!--=== Page Content ===-->
<div class="row">
	<div class="col-md-12">
		<div class="tabbable tabbable-custom tabbable-full-width">
			<ul class="nav nav-tabs profile">
				<li class="active"><a href="#tab_overview" data-toggle="tab">Overview</a></li>
				<li><a href="#tab_edit_account" data-toggle="tab">Edit Account</a></li>
			</ul>
			<div class="tab-content row">
				<!--=== Overview ===-->
				<div class="tab-pane active" id="tab_overview">

					<div class="col-md-9">
						<div class="row profile-info">
							<div class="col-md-7">
								<dl class="dl-horizontal">
									<dt>Name:</dt>
									<dd>{{ $user_detail['name'] }}</dd>
									<dt>Email / Staff Id:</dt>
									<dd>{{ $user_detail['email'] }}</dd>
								</dl>

							</div>
						</div> <!-- /.row -->
						<!-- /.row -->
					</div> <!-- /.col-md-9 -->
				</div>
				<!-- /Overview -->

				<!--=== Edit Account ===-->
				<div class="tab-pane" id="tab_edit_account">
					{!! Form::open(['url' => action('Settings\ProfileController@store'),'enctype' => 'multipart/form-data']) !!}
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h4 class="color-black-must">Update Information</h4>
							</div>
							<div class="widget-content">
								<div class="row">
									<div class="col-md-6">
										<input type="hidden" name="id" value="{{ $user_detail['id'] }}" />
										<div class="form-group">
											<label class="col-md-4 control-label">Name:</label>
											<div class="col-md-8">
												<input type="text" name="name" class="form-control mb-10" value="{{ $user_detail['name'] }}">
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-4 control-label">New password:</label>
											<div class="col-md-8">
												<input type="password" name="new_password" class="form-control mb-10" placeholder="Leave empty for no password-change">
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-4 control-label">Repeat new password:</label>
											<div class="col-md-8">
												<input type="password" name="new_password_confirmation" class="form-control mb-10" placeholder="Leave empty for no password-change">
											</div>
										</div>
										@if ($is_doctor && ($user_detail['RoleId'] == 1 || $user_detail['RoleId'] == 2))
										<input type="hidden" name="doctor_id" value="{{ $user_detail['mas_id'] }}" />
										<div class="form-group">
											<label for="Qualification" class="col-md-4 control-label">Qualification:</label>
											<div class="col-md-8">
												<input type="text" name="Qualification" value="{{ $user_detail['Qualification'] }}" class="form-control mb-10">
											</div>
										</div>
										<div class="form-group">
											<label for="job_title" class="col-md-4 control-label">Job Title:</label>
											<div class="col-md-8">
												<input type="text" name="job_title" value="{{ $user_detail['job_title'] }}" class="form-control mb-10">
											</div>
										</div>
										<div class="form-group">
											<label for="register_no" class="col-md-4 control-label">Reg. No:</label>
											<div class="col-md-8">
												<input class="form-control mb-10" name="register_no" value="{{ $user_detail['register_no'] }}" type="text" id="register_no">
											</div>
										</div>
										<div class="form-group">
											<label for="short_code" class="col-md-4 control-label">Short Code:</label>
											<div class="col-md-8">
												<input class="form-control mb-10" name="short_code" value="{{ $user_detail['short_code'] }}" type="text" id="short_code">
											</div>
										</div> 
										@elseif ($is_nurse && $user_detail['RoleId'] == 3)
										<input type="hidden" name="nurse_id" value="{{ $user_detail['mas_id'] }}" />
										<!-- <div class="form-group">
											<label for="register_no" class="col-md-4 control-label">Register No:</label>
											<div class="col-md-8">
												<input class="form-control mb-10" name="register_no" value="{{ $user_detail['register_no'] }}" type="text" id="register_no">
											</div>
										</div> -->
										@endif
										

										@include('settings.users.signature', ['id' => $user_detail['id'], 'signature' => $user_detail['signature'], 'initial' => $user_detail['initial']])
   
									</div>
								</div> <!-- /.row -->
							</div> <!-- /.widget-content -->
						</div> <!-- /.widget -->
					</div> <!-- /.col-md-12 -->

					<div class="col-md-12 form-vertical no-margin">
						<!-- /.widget -->

						<div class="form-actions">
							<input type="submit" value="Update Account" class="btn save-button-shadow btn-primary pull-right">
						</div>
					</div> <!-- /.col-md-12 -->
					{!! Form::close(); !!}
				</div>
				<!-- /Edit Account -->
			</div> <!-- /.tab-content -->
		</div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->                
@endsection
@if ($errors->any())
@section('scripts')
<script type="text/javascript">
	$(".nav-tabs.profile li:eq(1) a").trigger('click');   
</script>
@endsection
@endif
