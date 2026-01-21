@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i> <a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\DoctorController@index') }}">Doctors & Surgeons</a></li>       
		<li class="current"><a>Create</a></li>                                                 
	</ul>
</div>
<!-- /Breadcrumbs line -->

<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="master-layout">
    {!! Form::open(['url' => action('Masters\DoctorController@store'),'id'=> 'checkform']) !!}
    <div class="col-md-12 col-sm-12 col-xs-12 overflow-auto">
      <table class="master_doctors table table-add-more full-width-fix">
        <thead>
          <tr>
           <th colspan="2">Doctor's Name</th>
           <th>Qualification</th>
           <th>Job Title</th>
           <th>Reg. No:</th>
           <th>Type</th>                   
           <th>Status</th>                     
           <th>
            <span>
              <a class="btn btn-success master_doctors_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
            </span>                
          </th>                                                
        </tr>
      </thead>
      <tbody>
        <tr data-len="0">
          <td>
            <input type="text" name="name_prefix[]" value="Dr" readonly="true" class="form-control input-width-mini input-fields-shadow"/>
          </td>
          <td>
           <input type="text" name="Name[]" value="" class="form-control input-width-large input-fields-shadow name" />
         </td>
         <td>
           <input type="text" name="Qualification[]" value="" class="form-control input-width-large input-fields-shadow" />
         </td>
         <td>
          <input type="text" name="job_title[]" value="" class="form-control input-width-large input-fields-shadow">
        </td>
         <td>
          <input type="text" name="register_no[]" value="" class="form-control input-width-medium input-fields-shadow">
        </td>
        <td>
          <select name="type[]" class="form-control input-width-small input-fields-shadow">
            <option selected="selected" value="1">Doctors</option>
            <option value="2">Surgeons</option>     
            <option value="3">Others</option>                                        
          </select>
        </td>
        <td>
          <select name="status[]" class="form-control input-width-small input-fields-shadow">
           <option selected="selected" value="1">Active</option>
           <option value="0">Inactive</option>                                             
         </select>
       </td>
       <td>
        <span class="fa fa-trash btn btn-danger btn-view remove"></span>
      </td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="7">
        <div class="master-btn-layout">
          <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium">
            <i class="fa fa-floppy-o"></i> Save
          </button>
          <a href="{{ action('Masters\DoctorController@index') }}" class="btn btn-default form-control btn-basic-shadow input-width-medium" onclick="$('form')[0].reset();">
            <i class="fa fa-exclamation-circle"></i> 
            Cancel
          </a>
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
