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
            <a href="{{ action('Masters\RespiratoryIndicationController@index') }}">Respiratory Indication</a>
        </li>
        <li class="current">
            <a>Edit</a>
        </li>
    </ul>

</div>
<!-- /Breadcrumbs line -->

<!-- Page Header -->
<!-- <div class="page-header"> -->

    <!-- </div> -->
    <!-- /Page Header -->

    <!--=== Page Content ===-->
    <div class="row row-spacing select-container-main">
        <div class="master-btn-layout">
           {!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\RespiratoryIndicationController@update',$results->id),'id'=>'EditForm']) !!}

           <div class="row select-option-container">
            <div class="col-md-12">
                <div class="form-group row">
                  <div class="col-md-3 text-right label-control">
                    {!! Form::label('respiratory_name','Respiratory Name:') !!}
                </div>
                <div class="col-md-9 custom-input">
                    {!! Form::text('respiratory_name',null,['class'=>'form-control input-fields-shadow']) !!}
                </div>
            </div>

            <div class="form-group row">
              <div class="col-md-3 text-right label-control">
                {!! Form::label('respiratory_status','Respiratory Status:') !!}
            </div>
            <div class="col-md-9 custom-input">
                {!! Form::select('respiratory_status',['1'=>'Active','0'=>'Inactive'],null,['class'=>'form-control input-fields-shadow']) !!}
            </div>
        </div>
    </div>
  <div class="col-md-12 select-container-main">
    <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium"><i class="fa fa-floppy-o"></i> <span>Update</span>
        </button>
    <a href="{{ action('Masters\RespiratoryIndicationController@index') }}" class="btn btn-default form-control btn-basic-shadow input-width-medium"
        onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
    </a>
  </div>
</div>
{!! Form::close() !!}
@include('errors.list')
</div>
</div>  

@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#EditForm').validate({
            rules: {
                respiratory_name: {
                    required: true
                }
            }
        });
    });
</script>
@endsection


