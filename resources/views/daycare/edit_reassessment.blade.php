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
			<a href="{{ action('Masters\AntibioticController@index') }}">Antibiotics</a>
		</li>       
		<li class="current">
			<a>Create</a>
		</li>                                                 
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
  <div class="master-layout-2">
    {!! Form::open(['url' => action('Masters\AntibioticController@store'),'id'=> 'checkform']) !!}
    {!! Form::hidden('Id',null,['class'=>'form-control','id'=>'Id']) !!}
    <div class="col-md-12 overflow-auto">
      <table class="master_antibiotic table table-add-more full-width-fix">
        <thead>
          <tr>
            <th>Name</th>
            <th>Value</th>
            <th>Status</th>                    
            <th>
              <span>
                <a class="btn btn-success master_antibiotic_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
              </span>                
            </th>                                                        
          </tr>
        </thead>
        <tbody>
          <tr data-len="0">
            <td><input type="text" name="Name[]" value="" class="form-control input-fields-shadow input-width-medium name"/></td>
            <td><input type="text" name="Value[]" value="" class="form-control input-fields-shadow input-width-medium" /></td>
            <td><select name="Status[]" class="form-control input-fields-shadow input-width-medium">
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
              <button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium"><i class="fa fa-floppy-o"></i> Save</button>
              <a href="{{ action('Masters\AntibioticController@index') }}" class="btn btn-basic-shadow btn-default form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
            </div>
          </td>
        </tr>
      </tfoot>
    </table> 
  </div>
  {!! Form::close() !!}
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
  $(document).on('click', '.btn.btn-primary', function(event) {

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

</script>
@endsection
