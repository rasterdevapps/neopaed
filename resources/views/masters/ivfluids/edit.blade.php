@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\IvFluidsController@index') }}">IV Fluids</a></li>       
		<li class="current"><a>Edit</a></li>                                              
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="master-btn-layout">
		{!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\IvFluidsController@update',$results->id),'id'=>'EditForm']) !!}
	      @include('masters.ivfluids.form',['SubmitButtonText'=>'Update'])
	    {!! Form::close() !!}
	    @include('errors.list')
	</div> <!-- /.col-md-12 -->                   
</div> <!-- /.row -->
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $('.btn.btn-primary').on('click', function(event) {

            $('#EditForm input').each(function() {
                $(this).rules("add", {
                    required: true
                });
            });

            if($('#EditForm').validate().form()) {
                return true;
            } else {
                return false;
            }
        });

        $('#EditForm').validate();

   });
</script>
@endsection

