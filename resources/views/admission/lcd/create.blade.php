@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ action('Admission\IcdController@index') }}">ICD 10</a>
        </li>
        <li class="current">
            <a>Create</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->

<!-- Page Header -->
<div class="page-header">
</div>
<!-- /Page Header -->

<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
    <div class="master-btn-layout">
        {!! Form::open(['url' => action('Admission\IcdController@store'),'id'=> 'checkform']) !!}
        {!! Form::hidden('Id',null,['class'=>'form-control','id'=>'Id']) !!}

        <div class="row select-option-container">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('ICDCode','ICD Code:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('ICDCode',null,['class'=>'form-control input-fields-shadow']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('ICDDescription','ICD Description:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('ICDDescription',null,['class'=>'form-control input-fields-shadow']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        {!! Form::label('ICDFormat','ICD Format:') !!}
                    </div>
                    <div class="col-md-9 custom-input">
                        {!! Form::text('ICDFormat',null,['class'=>'form-control input-fields-shadow']) !!}
                    </div>
                </div>
            </div>

            <div class="col-md-12 select-container-main">
                <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium"><i class="fa fa-floppy-o"></i> <span>Save</span>
                </button>
                <a href="{{ action('Admission\IcdController@index') }}" class="btn btn-default form-control btn-basic-shadow input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
            </div>
        </div>


        {!! Form::close() !!}
        @include('errors.list')
    </div>
    <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $('#checkform .btn.btn-primary').on('click', function(event) {

            $('#checkform input[name="ICDCode"]').each(function() {
                $(this).rules("add", {
                    required: true
                });
            });

            if($('#checkform').validate().form()) {
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
