@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<style type="text/css">
input[type='file'] {
  	color: transparent;    
}
</style>
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li>
			<a href="{{ action('PhotoVideoUploadController@index') }}">Upload</a>
		</li>
		<li>
			<a href="{{ action('PhotoVideoUploadController@create') }}">Create</a>
		</li>                                         
	</ul>
</div>
<div class="row-spacing">
    <div class="col-md-12 tab-view-shadow ptb-15">
    	{{ Form::open(['method' => 'POST','url' => action('PhotoVideoUploadController@store'),'files' => true]) }}
    		<div class="form-group">
    			{{ Form::label('babymrno','Baby '. Lang::get('home.mrn')) }}
    			{{ Form::select('babymrno',['N/A' => 'N/A']+$babymrno,null,['class'=>'form-control']) }}</td>
    		</div>
    		<div class="form-group">
    			{{ Form::label('uploadtype','Upload Type') }}
    			{{ Form::select('uploadtype',['N/A' => 'N/A', 'photo' => 'photo', 'video' => 'video'],null,['class'=>'form-control']) }}</td>
    		</div>
    		<div class="form-group">
    			{{ Form::label('description','Description') }}
    			{{ Form::textarea('description',null,['class'=>'form-control','rows'=>5]) }}</td>
    		</div>
    		<div class="col-md-12 form-group">
    			<div class="photo">
    				{{ Form::label('photo','Upload the photo') }}
    				{{ Form::file('photo') }}
    				{{ Form::hidden('photovalue',null,['id'=>'photovalue']) }}
    			</div>
    			<div class="video">
    				{{ Form::label('video','Upload the video') }}
    				{{ Form::file('video') }}
    				{{ Form::hidden('videovalue',null,['id'=>'videovalue']) }}
    			</div>
    		</div> 
    		<div class="col-md-12 text-center pt-15">     		
    			<button type="submit" name="submit" class="btn btn-primary save-button-shadow save-btn" disabled="true">
	    			<i class="fa fa-save" aria-hidden="true"></i>
	    			<span>Save</span>
	    		</button>
	            <a href="{{ action('PhotoVideoUploadController@index') }}" class="btn btn-default save-button-shadow">
	            	<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
	            	<span>Cancel</span>
	            </a>
	        </div>
    	{{ Form::close() }}
    </div>
</div>
@endsection
@section('scripts') 
	<script type="text/javascript">
		$(document).ready(function() {
			$('.photo').addClass('display-none');
			$('.video').addClass('display-none');
			$('#uploadtype').prop('disabled', true);
			$('#babymrno').change(function() {
				if ($('#babymrno').val() == '') {
					$('#uploadtype').prop('disabled', true);
				} else {
					$('#uploadtype').prop('disabled', false);
				}
			});
			$('#uploadtype').change(function() {
				if ($('#uploadtype').val() == 'photo') {
					$('.photo').addClass('display-block').removeClass('display-none');
					$('.video').addClass('display-none');
				} else if ($('#uploadtype').val() == 'video') {
					$('.video').addClass('display-block').removeClass('display-none');
					$('.photo').addClass('display-none');
				} else {
					$('.photo').addClass('display-none');
					$('.video').addClass('display-none');					
				}
			});			
		});
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$('#photo').fileupload({
			url : "{{ action('PhotoVideoUploadController@uploadPhoto') }}",
			dataType: 'json',
			success: function (output) {
		        console.log(output.photoname+'-Upload successfully.');                           
		        $('.photo').append('<span>'+output.photoname+'</span>');
		        $('#photovalue').val(output.photoname);
		        $('.save-btn').prop("disabled",false);
		    },
		    error: function () {
		        console.log('Upload unsuccessfully.');
		    }
		});

		$('#video').fileupload({
			url : "{{ action('PhotoVideoUploadController@uploadVideo') }}",
			dataType: 'json',
			success: function (output) {
		        console.log(output.videoname+'-Upload successfully.');                           
		        $('.video').append('<span>'+output.videoname+'</span>');
		        $('#videovalue').val(output.videoname);		        	
		        $('.save-btn').prop("disabled",false);
		    },
		    error: function () {
		        console.log('Upload unsuccessfully.');
		    }
		});	
	</script>
@endsection
<!-- https://warlord0blog.wordpress.com/2018/02/22/laravel-5-jquery-file-upload/ -->

<!-- https://blueimp.github.io/jQuery-File-Upload/ -->

<!-- https://ffmpeg.org/documentation.html -->
