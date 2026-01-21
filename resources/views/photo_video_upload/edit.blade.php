@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<style type="text/css">
	video {
		width: 100%
		height: auto;
	}
	#content .container {

    width: 100%;
    height: 94vh;
    /*background: grey;*/
    display: flex;
    flex-direction: column;
    overflow: hidden;

	}
	.row-spacing {

    display: flex;
    margin-bottom: 20px;
	}

	.tab-view-shadow {
		    overflow-y: auto;
    padding: 20px;
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
			<a href="{{ action('PhotoVideoUploadController@edit',$upload->Id) }}">Edit</a>
		</li>                                         
	</ul>
</div>
<div class="row-spacing">
    <div class="col-md-12 tab-view-shadow ptb-15">
    	<div class="col-md-12 plr-0">
    		<div class="form-group">
    			{{ Form::label('babymrno','Baby '. Lang::get('home.mrn')) }}
    			{{ Form::select('babymrno',$babymrno,$upload->BMrNo,['class'=>'form-control']) }}</td>
    		</div>
    		<div class="form-group">
    			{{ Form::label('description','Description') }}
    			{{ Form::textarea('description',$upload->description,['class'=>'form-control','rows'=>5]) }}</td>
    		</div>
    		<div class="col-md-12">
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
    		<div class="text-center uploadphoto">
	    		@php $photos = glob($photo_path.$upload->BMrNo.'/*'); @endphp
		        @foreach ($photos as $photo)
		            @if (is_file($photo)) 
		            	<div class="col-md-3 img-upload">
				            <img src='{{ asset($photo) }}' alt="Image not found" class="col-md-11 padding-none" style="border: 20px solid #4d7496; height: 200px; margin-top: 20px">
				            <div class="col-md-1" style="padding: 0;margin-top: 20px;position: relative;left: -23px;">
				            	<a href="{{ action('PhotoVideoUploadController@deletePhoto', ['id' => $upload->Id, 'photo'=> $photo]) }}">
					            	<i class="fa fa-times" aria-hidden="true" style="background-color: #2f2c2c4f;padding: 5px 7px;border-radius: 11px; color: white"></i>
					            </a>
				            </div>
				        </div>
		            @endif
		        @endforeach
    			@php $videos = glob($video_path.$upload->BMrNo.'/*'); @endphp
		        @foreach ($videos as $video)
		            @if (is_file($video)) 
		            	<div class="col-md-3">
			                <video controls class="col-md-11 padding-none" height="200px" style="border: 20px solid #4d7496;object-fit: unset; margin-top: 20px">
						       <source src="{{ asset($video) }}" type="video/mp4">
						       Your browser does not support the video tag.
						   	</video>
						   	<div class="col-md-1" style="padding: 0;margin-top: 20px;position: relative;left: -23px;">
				            	<a href="{{ action('PhotoVideoUploadController@deleteVideo', ['id' => $upload->Id, 'video'=> $video]) }}">
					            	<i class="fa fa-times" aria-hidden="true" style="background-color: #2f2c2c4f;padding: 5px 7px;border-radius: 11px; color: white"></i>
					            </a>
				            </div>
						</div>
		            @endif
		        @endforeach				
    		</div>
    	</div>
  		<div class="col-md-12 text-center pt-15">
	        <a href="{{ action('PhotoVideoUploadController@index') }}" class="btn btn-default save-button-shadow">
	        	<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
	        	<span>Cancel</span>
	        </a>
	    </div>
    </div>
</div>
@endsection
@section('scripts') 
	<script type="text/javascript">
		$(document).ready(function() {
			$('.photo').addClass('display-none');
			$('.video').addClass('display-none');
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
				$('.uploadvideo').addClass('display-none');				
				$('.uploadphoto').addClass('display-none');	
			});		

			if ($('#uploadtype').val() == 'photo') {
				$('.uploadvideo').addClass('display-none');				
			} else if ($('#uploadtype').val() == 'video') {
				$('.uploadphoto').addClass('display-none');				
			}
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
		        $('#videovalue').val(output.photoname);		        	
		    },
		    error: function () {
		        console.log('Upload unsuccessfully.');
		    }
		});
		var $video  = $('video'),
    $window = $('.video-upload'); 

$(window).resize(function(){
    
    var height = $window.height();
    $video.css('height', height);
    
    var videoWidth = $video.width(),
        windowWidth = $window.width(),
    marginLeftAdjust =   (windowWidth - videoWidth) / 2;
    
    $video.css({
        'height': height, 
        'width': height, 
    });
}).resize();
	</script>
@endsection
