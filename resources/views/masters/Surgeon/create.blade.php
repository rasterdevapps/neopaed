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
                <a title="" href="{{ action('Masters\SurgeonController@index') }}">Surgeons</a>
            </li>
            <li class="current">
                <a title="">Create</a>
            </li>
        </ul>

    </div>
    <!-- /Breadcrumbs line -->

    <!-- Page Header -->
    <!-- <div class="page-header">
       <div class="page-title">
           <h3>Surgeons</h3>
       </div>
    </div> -->
    <!-- /Page Header -->

    <div class="row row-spacing">
       <div class="col-md-9">
         {!! Form::open(['url' => action('Masters\SurgeonController@store')]) !!}
         
            <div class="col-md-12">
              <table class="master_surgeon multi-row col-md-12">
                <thead>
                  <tr>
                    <th>Surgeon Name</th>
                    <th> Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{!! Form::text('surgeon_name[]','',['class'=>'form-control input-width-large']) !!}</td>
                    <td>{!! Form::select('status[]',['1'=>'Active','0'=>'Inactive'],'',['class'=>'form-control input-width-medium'])!!}</td>
                            <td><span class="fa fa-remove btn btn-default remove"></span></td>
                        </tr>
                    </tbody>
                </table>
                <a class="btn master_surgeon_add btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i> <span>Add More</span></a>

                <div class="row">
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary form-control"><i class="fa fa-floppy-o"></i> <span>Save</span>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ action('Masters\SurgeonController@index') }}"
                           class="btn btn-default form-control" onclick="$('form')[0].reset();"><i
                                    class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                    </div>
                </div>
            </div>
                   {!! Form::close() !!}

      </div>
   </div>

@endsection     
