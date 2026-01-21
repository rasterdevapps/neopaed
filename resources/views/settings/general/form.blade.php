@extends('app')
@section('content')
				<!-- Breadcrumbs line -->
				<div class="crumbs bread-crumbs-shadow">
					<ul id="breadcrumbs" class="breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{ url('/') }}">Dashboard</a>
                            
						</li>
						<li class="">
							<a title="" href="{{ action('Settings\SiteController@index') }}">Site Setting</a>
						</li>
					</ul>
				</div>
				<!-- /Breadcrumbs line -->
				<!-- Page Header -->
				<!-- <div class="page-header"> -->
				<!-- </div> -->
				<!-- /Page Header -->

				<div class="row row-spacing">
					<div class="col-md-9">
                       {!! Form::model($results,['url' => action('Settings\SiteController@store'),'method'=>'POST', 'files'=>true]) !!}                    
						<div class="col-md-5 ">
                       		<div class="form-group">
                            	{!! Form::label('SiteName','Site Name:') !!}
                                {!! Form::text('SiteName',null,['class'=>'form-control']) !!}
                            </div>
                       		<div class="form-group">
                            	{!! Form::label('LogoImage','Logo Image:') !!}
								{!! Form::file('LogoImage') !!}
                            </div>                            
                       		<div class="form-group">
                            	{!! Form::label('PrintLogo','Print Logo:') !!}
								{!! Form::file('PrintLogo') !!}
                            </div>  
                                                                    
                         </div>
                        <div class="col-md-12 ">
						<div class="row">
                            <div class="col-md-3">
                                   <button type="submit" class="btn btn-primary form-control"><i class="fa fa-floppy-o"></i> <span>Update</span></button>
                            </div>
                            <div class="col-md-3">
                                 <a href="{{ action('Settings\SiteController@index') }}" class="btn btn-default form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                            </div>
                        </div>      
                        </div>                   
                       {!! Form::close() !!}
    	               @include('errors.list')
                    </div>                                      
                </div>                
@endsection
