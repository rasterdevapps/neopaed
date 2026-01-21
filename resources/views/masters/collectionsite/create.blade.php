@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\CollectioSiteController@index') }}">Collection Site</a></li>       
		<li class="current"><a>Create</a></li>                                                 
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-9 master-layout">
    {!! Form::open(['url' => action('Masters\CollectioSiteController@store'),'id'=> 'checkform']) !!}
      <div class="col-md-12">
        <table class="masters-collection-method multi-row col-md-12">
          <thead>
            <tr>
              <th>Name</th>
              <th>Status</th>                    
              <th></th>                                                        
            </tr>
          </thead>
          <tbody>
            <tr data-len="0">
              <td><input type="text" name="Name[]" value="" class="form-control input-width-medium input-fields-shadow name" /></td>
              <td>
                  <select name="Status[]" class="form-control input-width-medium input-fields-shadow">
                    <option selected="selected" value="Active">Active</option>
                    <option value="Inactive">Inactive</option>                                             
                  </select>
              </td>
              <td><a class="btn btn-default remove btn-basic-shadow"><i class="fa fa-remove"></i></a></td>
            </tr>
          </tbody>
        </table>    	
        <a class="btn master-add-collection-method btn_add btn-basic-shadow" href="javascript:void(0);">
          <i class="fa fa-plus"></i> <span>Add More</span>
        </a>
        <div class="row">
          <div class="col-md-3 col-sm-4">
              <button type="submit" class="btn btn-primary form-control btn-basic-shadow btn-block">
                <i class="fa fa-floppy-o"></i> <span>Save</span>
              </button>
          </div>
          <div class="col-md-3 col-sm-4">
                  <a href="{{ action('Masters\CollectioSiteController@index') }}" class="btn btn-default form-control btn-basic-shadow btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
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

