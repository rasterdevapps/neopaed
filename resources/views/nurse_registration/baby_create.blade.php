@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Registration\BabyController@index') }}">Baby Registration</a></li>       
		<li class="current"><a>Create</a></li>                                                 
	</ul>
</div>
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
        @include('errors.list')
	        {!! Form::open(['url' => action('Registration\NurseBabyController@index'), 'id' => 'baby_reg_form']) !!}
	        {!! Form::hidden('MotherId',$id) !!}
			@include('nurse_registration.baby_form',['SubmitButtonText'=>$SubmitButtonText])
        {!! Form::close() !!}
    </div> <!-- /.col-md-9 -->  
</div> <!-- /.row -->                             
<script type="text/javascript">
	
$(document).on('click', '#baby-form-data', function(e){
    e.preventDefault();
    if ($('#baby_reg_form').valid() === true) {

        $(this).prop('disabled', true);

        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');

        $('#baby_reg_form').submit();
    }
});
</script>
@endsection
@section('scripts')
<script type="text/javascript">
/* PLUGIN USED FOR FORM LOCAL STORAGE */
$(document).ready(function() {
	setInterval(function() {
		$('#ward_name').val($.cookie("wardId")).trigger('change');
		$('#room_no').val($.cookie("roomId")).trigger('change');
		$('#bed_no').val($.cookie("bedId")).trigger('change');
		
},500)
	
});
$( "#baby-reg-form" ).sisyphus({  customKeySuffix: "baby", locationBased: true });

</script>
@endsection
