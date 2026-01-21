@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Registration\BabyController@index') }}">Baby Registration</a></li>       
		<li class="current"><a>Edit</a></li>                                                 
	</ul>
    <div class="pull-right">
        @php 
        $mmrn = $results->BMrNo; 

        echo \SiteHelpers::menuList($mmrn, 'baby_registration');
        @endphp
    </div>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12 plr-25">
       @include('errors.list')
       {!! Form::model($results,['method'=> 'PATCH','url' => action('Registration\BabyController@update',$results->BabyId), 'id'=> 'baby_reg_form', 'class'=>'edit-form']) !!}
       {!! Form::hidden('MotherId',null) !!}
       @include('registration.baby_form',['SubmitButtonText'=>'Update & Close','SavedhereText'=>'Update','neonatalPerforma'=>'Neonate','opRegister'=>'Create Op'])
       {!! Form::close() !!}
   </div> <!-- /.col-md-12 -->    
</div> <!-- /.row -->
<!-- /Page Content -->
<script type="text/javascript">
	
	$(document).on('change', '#baby_reg_form input, #baby_reg_form select', function()
    {
        $(this).addClass('not_saved');
    });
// $(document).on('click', '.baby_save_btn', function(e){
    $('.baby_save_btn').click(function(e){
    // alert('clicked')
    e.preventDefault();
    if ($('#baby_reg_form').valid() === true) {
        var print_flag = $(this).data('flag');
        $('#baby_form_print_flag').val(print_flag);
        $('.baby_save_btn').prop('disabled', true);

        var current_element = $(this);
        var current_element_html = $(this).html();
        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        // $('#mother_registration_form').submit();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'PATCH',
            data: $('#baby_reg_form input, #baby_reg_form select').serialize(),
            url: "{{ action('Registration\BabyController@update', $results->BabyId) }}",
            success: function (response) {
                if (print_flag == 2) {
                    Showalert('success', 'Baby Registered Successfully');
                    $('.baby_save_btn').prop('disabled', false);
                    current_element.html('<i class="fa fa-floppy-o"></i> <span>Update</span>');
                    // window.location.href = response.edit_url;
                }
                else if(print_flag == 3)
                {
                    Showalert('success', 'Baby Registered Successfully');
                    window.location.href = response.create_proforma_url;
                }
                else if(print_flag == 5)
                {
                    Showalert('success', 'Baby Registered Successfully');
                    window.location.href = response.op_create_url;
                }
                else
                {
                    Showalert('success', 'Baby Registered Successfully');
                    window.location.href = response.list_url; 
                }
            },
            error: function(response)
            {
                $('.baby_save_btn').prop('disabled', false);
                current_element.html(current_element_html);
                if (response.responseJSON.validate_mrn !== undefined) {
                    Showalert('error', response.responseJSON.message);
                }
                else
                {
                    Showalert('error', 'Something went wrong, Please try again later...!');
                }
            }
        });
    }
});
</script>
@endsection
@section('scripts')
<script type="text/javascript">
    /* PLUGIN USED FOR FORM LOCAL STORAGE */


    $( "form" ).sisyphus({  customKeySuffix: "baby", locationBased: true });

</script>
@endsection
