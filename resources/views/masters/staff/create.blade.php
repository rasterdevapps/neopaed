@extends('app')
@section('content')
	<!-- Breadcrumbs line -->
	<div class="crumbs bread-crumbs-shadow">
	 	<ul id="breadcrumbs" class="breadcrumb">
			<li><i class="icon-home"></i> <a href="/">Dashboard</a></li>
		    <li><a href="{{ action('Masters\StaffController@index') }}">Admission Mode</a></li>       
			<li class="current"><a>Create</a></li>                                                 
		</ul>

	</div>
	<!-- /Breadcrumbs line -->
	<!-- Page Header -->
	<!-- <div class="page-header">
	</div> -->
	<!-- /Page Header -->
	<!--=== Page Content ===-->
	<div class="row row-spacing">
		<div class="col-md-9">
        {!! Form::open(['url' => action('Masters\StaffController@store'),'id'=>'admission-mode']) !!}
      		<div class="col-md-12">
                <table class="master_admission_mode multi-row col-md-12">
                    <thead>
                        <tr>
                           <th>Name</th>
                           <th>Qualification</th>
                           <th>Designation</th>
                           <th>Status</th>                    
                           <th></th>                                                        
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           <td>
                              <input type="text" name="name[]" value="" class="form-control input-width-large" />
                           </td>
                           <td>
                              <input type="text" name="qualification[]" value="" class="form-control input-width-large" />
                           </td>
                           <td>
                              <input type="text" name="designation[]" value="" class="form-control input-width-large" />
                           </td>
                           <td>
                               <select name="status[]" class="form-control input-width-medium">
                                  <option selected="selected" value="">--select--</option>
                                  <option value="1">Active</option>
                                  <option value="0">Inactive</option>                                             
                               </select>
                           </td>
                           <td>
                               <span class="fa fa-remove btn btn-default remove"></span>
                           </td>
                        </tr>
                    </tbody>
                </table>    	
                <a class="btn master_staff_add btn_add" href="javascript:void(0);">
                    <i class="fa fa-plus"></i> 
                    <span>Add More</span>
                </a>
                <div class="row">
                   <div class="col-md-3">
                        <button type="submit" class="btn btn-primary form-control">
                           <i class="fa fa-floppy-o"></i> <span>Save</span>
                        </button>
                   </div>
                   <div class="col-md-3">
	                   <a href="{{ action('Masters\StaffController@index') }}" class="btn btn-default form-control" onclick="$('form')[0].reset();">
		                   <i class="fa fa-exclamation-circle"></i> 
		                   <span>Cancel</span>
	                   </a>
                   </div>
                </div>
            </div>
	        {!! Form::close() !!}
	      @include('errors.list')
		</div> <!-- /.col-md-12 -->
                         
    </div> <!-- /.row -->
				<!-- /Page Content -->

@endsection
@section('scripts')

<script type="text/javascript">


</script>

@endsection




