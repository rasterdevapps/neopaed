@extends('app')
@section('content')
				<!-- Breadcrumbs line -->
				<div class="crumbs bread-crumbs-shadow">
					<ul id="breadcrumbs" class="breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{ url('/') }}">Dashboard</a>
                            
						</li>
						<li>
							<a href="{{ action('Settings\UserController@index') }}">Users</a>
						</li>
						<li class="current">
							<a title="">Create</a>
						</li>                        
					</ul>
				</div>
				<!-- /Breadcrumbs line -->

				<!-- Page Header -->
				<div class="page-header">
				</div>
				<!-- /Page Header -->

				<div class="row">
                       <div class="form-group">
    	               @include('errors.list')
                       </div>                
					<div class="">
                       {!! Form::open(['url' => action('Settings\UserController@store')]) !!}
                       <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name','Name:') !!}
                                {!! Form::text('name',null,['class'=>'form-control']) !!}
                            </div>            
                        </div>
                       <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('Email','Email/Staff:') !!}
                                {!! Form::text('email',null,['class'=>'form-control']) !!}
                            </div>            
                        </div>
                       <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('Password','Password:') !!}
                                {!! Form::password('password',['class'=>'form-control']) !!}
                            </div>            
                        </div>
                       <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('Password_confirmation','Confirm Password:') !!}
                                {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
                            </div>            
                        </div>                        
                       <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('Usergroup','User Group:') !!}
                                {!! Form::select('RoleId',$roles,'',['class'=>'form-control']) !!}
                            </div>            
                        </div>	
					 </div>   
                     </div>                     		
						<div class="row">
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary form-control"><i class="fa fa-floppy-o"></i> <span>Save</span></button>
                            </div>
                            <div class="col-md-3">
                                 <a href="{{ action('Settings\UserController@index') }}" class="btn btn-default form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                            </div>
                        </div>                        			
                       {!! Form::close() !!}

                   
               
@endsection
