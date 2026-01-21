@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\CollectioSiteController@index') }}">Collection Site</a></li>       
		<li class="current"><a>Edit</a></li>                                              
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-9">
	{!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\CollectioSiteController@update',$results->id),'id'=>'EditForm']) !!}
        <div class="row">
			<div class="col-md-5 ">
                <div class="form-group">
                    {!! Form::label('name','Name:') !!}
                    {!! Form::text('name',null,['class'=>'form-control input-fields-shadow']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('status','Status:') !!}
                    {!! Form::select('status',['Active'=>'Active','Inactive'=>'Inactive'],null,['class'=>'form-control input-fields-shadow']) !!}
                </div>                        		
            </div>             
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <button type="submit" class="btn btn-primary form-control btn-basic-shadow btn-block">
                	<i class="fa fa-floppy-o"></i> 
                	<span>{!! $SubmitButtonText !!}</span>
                </button>
            </div>
            <div class="col-md-3 col-sm-4">
              <a href="{{ action('Masters\CollectioSiteController@index') }}" class="btn btn-default form-control btn-basic-shadow btn-block" onclick="$('form')[0].reset();">
              	<i class="fa fa-exclamation-circle"></i> 
              	<span>Cancel</span>
              </a>
            </div>
        </div>       
    {!! Form::close() !!}
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
				<!-- /Page Content -->

@endsection
@section('scripts')
<script type="text/javascript">

$( "form" ).sisyphus({  customKeySuffix: "mother", locationBased: true });
    $(document).ready(function() {
        $('#EditForm').validate({
            rules: {
                name: {
                    required: true
                }
            }
        });
    });
</script>
@endsection
