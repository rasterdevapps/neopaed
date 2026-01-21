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
			<a href="{{ action('Masters\DrugAndInfusionController@index') }}">Drugs And Infusion</a>
		</li>       
		<li class="current">
			<a>Create</a>
		</li>                                                 
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-9">
        {!! Form::open(['url' => action('Masters\DrugAndInfusionController@store')]) !!}
		<div class="col-md-12">
            <table class="master_drugs multi-row table col-md-12">
                <thead>
                    <tr>
                        <th>Brand Name</th>
                        <th>Generic Name(pharmacological name)</th>
                        <th>Formulations/Strength</th>
                        <th>Status</th>                    
                        <th></th>                                                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                     <td><input type="text" name="Name" data-nameLen="1" value="" class="form-control input-fields-shadow input-width-medium" /></td>
                     <td><input type="text" name="generic_name" value="" class=" form-control input-fields-shadow "></td>
                    
                     <td><input type="text" name="Value[]" value="" class="form-control input-fields-shadow input-width-medium" /></td>
                     <td>
                         <select name="Status[]" class="form-control input-fields-shadow input-width-medium">
                             <option selected="selected" value="Active">Active</option>
                             <option value="Inactive">Inactive</option>                                             
                         </select>
                     </td>
                     <td><span data-len="1" class="fa fa-plus btn btn-default btn-basic-shadow add-values"></span></td>
                     <td><span class="fa fa-remove btn btn-basic-shadow btn-default remove"></span></td>
                    </tr>
    
                </tbody>
            </table>    	
            <a class="btn master_drugs_add btn-basic-shadow btn_add hide" href="javascript:void(0);">
                <i class="fa fa-plus"></i>
                 <span>Add More</span>
            </a>
            <div class="row">
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-basic-shadow form-control">
                        <i class="fa fa-floppy-o"></i> <span>Save</span>
                    </button>
                </div>
                <div class="col-md-3">
                    <a href="{{ action('Masters\DrugAndInfusionController@index') }}" class="btn btn-default btn-basic-shadow form-control" onclick="$('form')[0].reset();">
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
