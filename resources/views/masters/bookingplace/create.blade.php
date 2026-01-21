
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
      <a href="{{ action('Masters\BookingPlaceController@index') }}">Booking Place</a>
    </li>       
    <li class="current">
      <a>Create</a>
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
    <div class="master-layout">
     {!! Form::open(['url' => action('Masters\BookingPlaceController@store'),'id'=> 'checkform']) !!}
     <div class="col-md-12 overflow-auto">
      <table class="booking_place table table-add-more full-width-fix">
        <thead>
          <tr>
            <th>Hospital Name</th>
            <th>Email Id</th>
            <th>Mobile No</th>
            <th>Status</th>                    
            <th>
              <span>
                <a class="btn btn-success booking_place_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
              </span>  
            </th>                                                        
          </tr>
        </thead>
        <tbody>
          <tr data-len="0">
            <td><input type="text" name="hospital_name[]" value="" class="form-control input-width-medium input-fields-shadow name" /></td>
            <td><input type="text" name="hospital_email[]" value="" class="form-control input-width-medium input-fields-shadow" /></td>
            <td><input type="text" name="hospital_number[]" value="" class="form-control input-width-medium input-fields-shadow" /></td>
            <td><select name="status[]" class="form-control input-width-medium input-fields-shadow">
              <option selected="selected" value="Active">Active</option>
              <option value="Inactive">Inactive</option> 
            </select>
          </td>
          <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
        </tr>

      </tbody>
      <tfoot>
        <tr>
          <td colspan="5">
            <div class="master-btn-layout">
              <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium"><i class="fa fa-floppy-o"></i> Save</button>
              <a href="{{ action('Masters\BookingPlaceController@index') }}" class="btn btn-default form-control btn-basic-shadow input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
            </div>
          </td>
        </tr>
      </tfoot>
    </table> 
</div>
{!! Form::close() !!}
@include('errors.list')
</div> <!-- /.col-md-12 -->

</div> <!-- /.row -->
<!-- /Page Content -->

@endsection
@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {

    $('.btn.btn-primary').on('click', function(event) {

      $('#checkform input.name').each(function() {
        $(this).rules("add", {
          required: true
        });
      });

      if($('#checkform').validate().form()) {
        return true;
      } else {
        return false;
      }
    });

    $('#checkform').validate();

  });
</script>
@endsection
