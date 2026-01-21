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
<style type="text/css">
    [type="radio"]:checked, [type="radio"]:not(:checked) {
        position: relative;
        left: 0;
        width: 0;
        height: 0;
        visibility: visible;
    }
</style>
<!-- /Page Header -->
<div class="col-md-12">
    @include('errors.list')
</div>
<div class="row select-container-main">
    <div class="">
        {!! Form::open(['url' => action('Settings\UserController@store'),'enctype' => 'multipart/form-data']) !!}
        <div class="col-md-12 user_create_class" >
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> User Info</h4>
                </div>
                <div class="widget-content row mx-0">
                    <div class="form-group row plr-15">
                        <div class="col-md-12 p-0">
                            {!! Form::label('name','Full Name:', ['class'=>'required-label']) !!}
                        </div>
                        <div class="col-md-12 display-flex plr-0">                            
                            {!! Form::hidden('name_prefix',null,['class'=>'name_prefix']) !!}
                            {!! Form::text('name_prefix',null,['class'=>'form-control input-width-small name_prefix','disabled']) !!}
                            {!! Form::text('name',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
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
                        {!! Form::select('RoleId',$roles,'',['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('status','Status:') !!}
                        {!! Form::select('status',['0'=>'Active','1'=>'Inactive'],null,['class'=>'form-control']) !!}
                    </div>
                    <div class="role-based-field"></div>

                    @include('settings.users.signature', ['id' => '', 'signature' => '', 'initial' => ''])

                    <div class="form-group hide signature-image-show-div">
                        <img src="#" id="signature-image-show" alt="Signature Image Not Found">
                    </div>
                    <div class="col-md-12 content-align-center">
                        <button type="submit" class="btn btn-primary form-control save-button-shadow"><i class="fa fa-floppy-o"></i> <span>Save</span></button>
                        <a href="{{ action('Settings\UserController@index') }}" class="btn btn-default form-control save-button-shadow ml-15" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
</div>
{!! Form::close() !!}
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
      $('.Status').hide();

      var selected = $("input[type='radio']");

      selected.change(function(){
          if (this.value == 'Yes') {
            $('.Status').show();
            $('#type').change(function() {
              if ($('#type').val() != 0) {
                $('.name_prefix').val('Dr');
            } else {
                $('.name_prefix').val('');
            }
        });
        } else {
            $('.Status').hide();
            $('.name_prefix').val('');
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

      $('select[name="RoleId"]').change(function() {

        var role_name = $(this).children('option:selected').prop('label');
        role_name = role_name.toLowerCase(); 

        if (role_name.indexOf('doctor') > -1) {

            $('.name_prefix').val('Dr');

            var doctor_master_fields = '<div class="form-group"><label for="Qualification" class="required-label">Qualification:</label><input type="text" name="Qualification" value="" class="form-control"></div><div class="form-group"><label for="job_title" class="required-label">Job Title:</label><input type="text" name="job_title" value="" class="form-control"></div><div class="form-group"><label for="register_no" class="required-label">Reg. No:</label><input class="form-control" name="register_no" type="text" id="register_no"></div><div class="form-group"><label for="type" class="required-label">Type:</label><select name="type" class="form-control"><option selected="selected" value="1">Doctors</option><option value="2">Surgeons</option><option value="3">Others</option></select></div><div class="form-group"><label for="short_code" class="required-label">Short Code:</label><input class="form-control" name="short_code" type="text" id="short_code"></div><div class="form-group"><label for="short_code" class="required-label">Summary Approval:</label><input id="summary_approval" data-size="small" name="summary_approval" data-off="Deny" data-on="Allow" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox"></div>';

            $('.role-based-field').html(doctor_master_fields);
            $("input[name='summary_approval']").bootstrapToggle();

        } else if (role_name.indexOf('nurse') > -1) {

            $('.name_prefix').val('');

            var nurse_master_fields = '<div class="form-group"><label for="register_no" class="required-label">Staff Id:</label><input type="text" name="register_no" value="" class="form-control"></div>';

            $('.role-based-field').html(nurse_master_fields);                

        } else {
            $('.name_prefix').val('');

            $('.role-based-field').html('');                
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
    
</script>
@endsection
