@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\IvFluidsController@index') }}">IV Fluids</a></li>       
		<li class="current"><a>Create</a></li>                                                 
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="master-layout">
    {!! Form::open(['url' => action('Masters\IvFluidsController@store'),'id'=> 'checkform']) !!}
    <div class="col-md-12 overflow-auto">
      <table class="master_ivfluids table table-add-more full-width-fix">
        <thead>
          <tr>
            <th>Pharmacological Name</th>
            <th>IV Fluids Brand Name</th>
            <th>Status</th>                  
            <th>
              <span>
                <a class="btn btn-success master_ivfluids_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
              </span>                
            </th>                                               
          </tr>
        </thead>
        <tbody>
          <tr data-len="0">
            <td><input name="pharmacological_name[]" type="text" class="form-control input-fields-shadow valid"></td>
            <td><input name="name[]" type="text" class="form-control input-fields-shadow input-width-medium valid"/></td>
            <td>
              <select name="status[]" class="form-control input-fields-shadow input-width-medium">
                <option selected="selected" value="Active">Active</option>
                <option value="Inactive">Inactive</option>                                             
              </select>
            </td>
            <td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
          </tr>
        </tbody>
      <tfoot>
        <tr>
          <td colspan="4">
            <div class="master-btn-layout">
              <button type="submit" class="btn btn-primary btn-basic-shadow form-control btn-block"><i class="fa fa-floppy-o"></i> Save</button>
              <a href="{{ action('Masters\IvFluidsController@index') }}" class="btn btn-basic-shadow btn-default form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
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

      $('#checkform input.valid').each(function() {
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

