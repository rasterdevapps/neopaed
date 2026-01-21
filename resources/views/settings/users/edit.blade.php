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
            <a title="">Edit</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!-- Page Header -->
<div class="page-header">
</div>
<!-- /Page Header -->
<div class="col-md-12">

        @include('errors.list')
    </div>
<div class="row select-container-main">
    <div class="">
        {!! Form::model($result,['url' => action('Settings\UserController@update',$result['id']),'method'=>'patch','enctype' => 'multipart/form-data']) !!}
        {!! Form::hidden('id'); !!}
        <div class="col-md-12">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> User Info</h4>
                </div>
                <div class="widget-content row mx-0">
                    <div class="form-group">
                        <div class="col-md-12 p-0">
                            {!! Form::label('name','Full Name:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-12 display-flex plr-0">   
                            {!! Form::hidden('name_prefix',null,['class'=>'prefix']) !!}
                            {!! Form::text('name_prefix',null,['class'=>'form-control input-width-small prefix name_prefix','disabled']) !!}
                            {!! Form::text('name',null,['class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="form-group mt-10">
                        {!! Form::label('Email','Email:', ['class'=>'required-label']) !!}
                        {!! Form::text('email',null,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Password','Password:', ['class'=>'required-label']) !!}
                        {!! Form::password('password',['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Password_confirmation','Confirm Password:') !!}
                        {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Usergroup','User Group:', ['class'=>'required-label']) !!}
                        {!! Form::select('RoleId',$roles,null,['class'=>'form-control', 'disabled'=>true]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('status','Status:', ['class'=>'required-label']) !!}
                        {!! Form::select('status',['0'=>'Active','1'=>'Inactive'],null,['class'=>'form-control']) !!}
                    </div>

                    {!! Form::hidden('temp_mas_id', @$result['mas_id']) !!}
                    {!! Form::hidden('temp_Qualification', @$result['Qualification']) !!}
                    {!! Form::hidden('temp_job_title', @$result['job_title']) !!}
                    {!! Form::hidden('temp_register_no', @$result['register_no']) !!}
                    {!! Form::hidden('temp_type', @$result['type']) !!}
                    {!! Form::hidden('temp_short_code', @$result['short_code']) !!}
                    {!! Form::hidden('temp_register_no', @$result['register_no']) !!}
                    {!! Form::hidden('temp_summary_approval', @$result['summary_approval']) !!}
                    <div class="role-based-field"></div>

                    @include('settings.users.signature', ['id' => $result['id'], 'signature' => $result['signature'], 'initial' => $result['initial']])

                    <div class="clearfix"></div>
                    <div class="col-md-12 content-align-center">
                        <button type="submit" class="btn btn-primary form-control save-button-shadow"><i class="fa fa-floppy-o"></i> <span>Update</span></button>
                        <a href="{{ action('Settings\UserController@index') }}" class="btn btn-default form-control save-button-shadow ml-15" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

      if ($('.ismasterval').val() == 1) {
        $("#isMaster").prop("checked", true);
        $('.prefix').val('Dr');
    } else {
        $("input[name=isMaster][value=No]").prop('checked', true);
        $('#type').val(0);      
        $('.Status').hide();
    }
    var selected = $("input[type='radio']");
    
    selected.change(function(){
        if (this.value == 'Yes') {
          $('.Status').show();
          $('#type').change(function() {
            if ($(this).val() != 0) {
              $('.prefix').val('Dr');
          } else {
              $('.prefix').val('');
          }
      });
      } else {
          $('.Status').hide();
          $('.prefix').val('');
      }
  });
    
    $('#type').change(function() {
        if ($(this).val() != 0) {
          $('.error').removeClass('display-block').addClass('display-none');
      }
  });
    
    $('.btn.btn-primary').click(function(){
        if ($('#isMaster').prop('checked')) {
          if ($('#type').val() != 0) {
            $('.error').removeClass('display-block').addClass('display-none');
            return true;
        } else {
            $('.error').addClass('display-block').removeClass('display-none');
            return false;
        }
    }
});

    $("#initial-image").change(function(){
        readURL(this,'initial');
        $('.initial-image-show-div').removeClass('hide');
    });

    $("#signature-image").change(function(){
        readURL(this,'signature');
        $('.signature-image-show-div').removeClass('hide');
    });
    function readURL(input, type) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                if (type == 'initial') {
                    $('#initial-image-show').attr('src', e.target.result);
                }
                else
                {
                    $('#signature-image-show').attr('src', e.target.result);
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('select[name="RoleId"]').trigger('change');
    
});
    $(document).on('change', 'select[name="RoleId"]',function() {

        var role_name = $(this).children('option:selected').prop('label');
        role_name = role_name.toLowerCase(); 

        if (role_name.indexOf('doctor') > -1) {

            var qualification = $('input[name="temp_Qualification"]').val();
            var job_title = $('input[name="temp_job_title"]').val();
            var register_no = $('input[name="temp_register_no"]').val();
            var type = $('input[name="temp_type"]').val();
            var short_code = $('input[name="temp_short_code"]').val();
            var summary_approval = $('input[name="temp_summary_approval"]').val();

            $('.name_prefix').val('Dr');
            var doctor_master_fields = '<div class="form-group"><label for="Qualification" class="required-label">Qualification:</label><input type="text" name="Qualification" value="" class="form-control"></div><div class="form-group"><label for="job_title" class="required-label">Job Title:</label><input type="text" name="job_title" value="" class="form-control"></div><div class="form-group"><label for="register_no" class="required-label">Reg. No:</label><input type="text" name="register_no" value="" class="form-control"></div><div class="form-group"><label for="type" class="required-label">Type:</label><select name="type" class="form-control"><option selected="selected" value="1">Doctors</option><option value="2">Surgeons</option><option value="3">Others</option></select></div><div class="form-group"><label for="short_code" class="required-label">Short Code:</label><input class="form-control" name="short_code" type="text" id="short_code"></div><div class="form-group"><label for="summary_approval" class="required-label">Summary Approval:</label><input id="summary_approval" data-size="small" name="summary_approval" data-off="Deny" data-on="Allow" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox"></div>';
            $('.role-based-field').html(doctor_master_fields);

            $("input[name='summary_approval']").bootstrapToggle();

            $('input[name="Qualification"]').val(qualification);
            $('input[name="job_title"]').val(job_title);
            $('input[name="register_no"]').val(register_no);
            $('select[name="type"]').val(type);
            $('input[name="short_code"]').val(short_code);
            if (summary_approval) {
                $('input[name="summary_approval"]').prop('checked', true).change();
            } else {
                $('input[name="summary_approval"]').prop('checked', false).change();                
            }

        } else if (role_name.indexOf('nurse') > -1) {

            var register_no = $('input[name="temp_register_no"]').val();

            $('.name_prefix').val('');

            var nurse_master_fields = '<div class="form-group"><label for="register_no" class="required-label">Staff Id:</label><input type="text" name="register_no" value="" class="form-control"></div>';

            $('.role-based-field').html(nurse_master_fields);   

            $('input[name="register_no"]').val(register_no);

        } else {

            if (role_name.indexOf('admin') > -1) {

                var admin_fields = '<div class="form-group"><label for="summary_approval" class="required-label">Summary Approval:</label><input id="summary_approval" data-size="small" name="summary_approval" data-off="Deny" data-on="Allow" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox"></div>';
            
                $('.role-based-field').html(admin_fields);   

                $("input[name='summary_approval']").bootstrapToggle();
                
                var summary_approval = $('input[name="temp_summary_approval"]').val();

                if (summary_approval) {
                    $('input[name="summary_approval"]').prop('checked', true).change();
                } else {
                    $('input[name="summary_approval"]').prop('checked', false).change();                
                }

            } else {

                $('.role-based-field').html('');

            }

            $('.name_prefix').val('');

        }

    });
    $(document).on('change', 'select[name="type"]', function() {
        var type = $(this).val();
        if (type == 3) {            
            $('.name_prefix').val('');
        } else {
            $('.name_prefix').val('Dr');
        }
    });
</script>
@endsection
