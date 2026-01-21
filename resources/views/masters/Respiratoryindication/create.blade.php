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
            <a title="" href="{{ action('Masters\RespiratoryIndicationController@index') }}">Respiratory Indication</a>
        </li>
        <li class="current">
            <a title="">Create</a>
        </li>
    </ul>

</div>
<!-- /Breadcrumbs line -->

<!-- Page Header -->
<!-- <div class="page-header"> -->
       <!-- <div class="page-title">
           <h3>Respiratory Indication</h3>
       </div> -->
       <!-- </div> -->
       <!-- /Page Header -->

       <div class="row row-spacing select-container-main">
           <div class="master-layout">
             {!! Form::open(['url' => action('Masters\RespiratoryIndicationController@store'),'id'=> 'checkform']) !!}

             <div class="col-md-12 overflow-auto">
              <table class="master_respiratory_indication table table-add-more full-width-fix">
                <thead>
                  <tr>
                    <th>Respiratory Name</th>
                    <th>Respiratory Status</th>
                    <th>
                      <span>
                        <a class="btn btn-success master_respiratory_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                    </span>                
                </th>
            </tr>
        </thead>
        <tbody>
          <tr data-len="0">
            <td>{!! Form::text('respiratory_name[]','',['class'=>'form-control input-width-large input-fields-shadow name']) !!}</td>
            <td>{!! Form::select('respiratory_status[]',['1'=>'Active','0'=>'Inactive'],'',['class'=>'form-control input-width-medium input-fields-shadow'])!!}</td>
            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
          <td colspan="4">
            <div class="master-btn-layout">
              <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium"><i class="fa fa-floppy-o"></i> Save
              </button>
              <a href="{{ action('Masters\RespiratoryIndicationController@index') }}"
              class="btn btn-default form-control btn-basic-shadow input-width-medium" onclick="$('form')[0].reset();"><i
              class="fa fa-exclamation-circle"></i> Cancel</a>
          </div>
      </td>
  </tr>
</tfoot>
</table>

</div>
{!! Form::close() !!}

</div>
</div>

@endsection     
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $('#checkform .btn.btn-primary').on('click', function(event) {

            $('#checkform input.name').each(function() {
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

