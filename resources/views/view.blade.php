@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
				<!-- Breadcrumbs line -->
				<div class="crumbs">
					<ul id="breadcrumbs" class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="{{ url('/') }">Dashboard</a>
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
													<dt>Email Id:</dt>
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
                                    {!! Form::open(['url' => action('Settings\ProfileController@store')]) !!}
										<div class="col-md-12">
											<div class="widget">
												<div class="widget-header">
													<h4>Update Information</h4>
												</div>
												<div class="widget-content">
													<div class="row">
														<div class="col-md-6">
                                                        	<input type="hidden" name="id" value="{{ $user_detail['id'] }}" />
															<div class="form-group">
																<label class="col-md-4 control-label">Name:</label>
																<div class="col-md-8"><input type="text" name="name" class="form-control" value="{{ $user_detail['name'] }}"></div>
															</div>

															<div class="form-group">
																<label class="col-md-4 control-label">New password:</label>
																<div class="col-md-8"><input type="password" name="new_password" class="form-control" placeholder="Leave empty for no password-change"></div>
															</div>

															<div class="form-group">
																<label class="col-md-4 control-label">Repeat new password:</label>
																<div class="col-md-8"><input type="password" name="new_password_confirmation" class="form-control" placeholder="Leave empty for no password-change"></div>
															</div>      
														</div>


														
													</div> <!-- /.row -->
												</div> <!-- /.widget-content -->
											</div> <!-- /.widget -->
										</div> <!-- /.col-md-12 -->

										<div class="col-md-12 form-vertical no-margin">
											 <!-- /.widget -->

											<div class="form-actions">
												<input type="submit" value="Update Account" class="btn btn-primary pull-right">
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
