
@extends('app')
@section('content')
<style>
  div.tinymce-body {
        border: 1px solid #CCCCCC !important;
        min-height: 100px;
        border-radius: 0px !important;
        padding: 5px;
        background-color: white;
    }
    div.tinymce-body:focus {
        border-color: #4d7496 !important;
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ action('Masters\ShortcodeController@index') }}">Short Code</a>
        </li>
        <li class="current">
            <a>Create</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->

<!-- Page Header -->
<div class="page-header"></div>
<!-- /Page Header -->

<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
    <div class="master-btn-layout">
        {!! Form::open(['url' => action('Masters\ShortcodeController@store'),'id'=> 'checkform']) !!}
        {!! Form::hidden('Id',null,['class'=>'form-control','id'=>'Id']) !!}

        <div class="row select-option-container">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('Short Code','Short Code:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('short_code',null,['class'=>'form-control input-fields-shadow']) !!}
                    </div>
                </div>
             <div class="form-group row">
                  <div class="col-md-3 text-right label-control">
                      {!! Form::label('Shortcode Description', 'Shortcode Description:') !!}
                  </div>
                  <div class="col-md-9 custom-input">
                    <div class="tinymce-body" id="description">
                        {!! $description ?? '' !!}
                     </div>

                  </div>
              </div>
                <div class="form-group row">
                  <div class="col-md-3 text-right label-control">
                      {!! Form::label('Status', 'Status:') !!}
                  </div>
                  <div class="col-md-9 custom-input">
                      {!! Form::select('active', [1 => 'Active', 0 => 'Inactive'], null, ['class' => 'form-control input-fields-shadow']) !!}
                  </div>
              </div>
            </div>

            <div class="col-md-12 select-container-main">
                <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium">
                    <i class="fa fa-floppy-o"></i> <span>Save</span>
                </button>
                <a href="{{ action('Masters\ShortcodeController@index') }}" 
                   class="btn btn-default form-control btn-basic-shadow input-width-medium" 
                   onclick="$('form')[0].reset();">
                   <i class="fa fa-exclamation-circle"></i> <span>Cancel</span>
                </a>
            </div>
        </div>

        {!! Form::close() !!}
        @include('errors.list')
    </div>
</div> <!-- /.row -->
@endsection

@section('styles')
<style type="text/css">

     div.tinymce-body {
        border: 1px solid #CCCCCC !important;
        min-height: 100px;
        border-radius: 0px !important;
        padding: 5px;
        background-color: white;
    }
    div.tinymce-body:focus {
        border-color: #4d7496 !important;
    }
    
</style>
@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function () {

        tinymce.init({
        selector: '.tinymce-body',
        menubar: false,
        inline: true,
        plugins: 'preview powerpaste casechange importcss autolink link table lists tinymcespellchecker',
        toolbar: ['undo redo | bold italic underline strikethrough | fontfamily fontsize blocks', 'alignleft aligncenter alignright alignjustify |  numlist bullist | forecolor backcolor casechange | preview | table']
      });


        // Form validation
        $('#checkform .btn.btn-primary').on('click', function (event) {
            $('#checkform input[name="short_code"]').each(function () {
                $(this).rules("add", {
                    required: true
                });
            });

            if ($('#checkform').validate().form()) {
                $(this).prop('disabled', true);
                $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
                $('#checkform').submit();
                return true;
            } else {
                return false;
            }
        });

        $('#checkform').validate();
    });
</script>
@endsection
