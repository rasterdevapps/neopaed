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
            <a href="{{ action('Masters\DrugController@index') }}">Drugs</a>
        </li>
        <li class="current">
            <a>Create</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
    <div class="master-layout">
        {!! Form::open(['url' => action('Masters\DrugController@store'),'id'=> 'checkform']) !!}
        <div class="col-md-12 overflow-auto">
            <table class="master_drugs table table-add-more full-width-fix">
                <thead>
                    <tr>
                        <th>Brand Name</th>
                        <th>Generic Name (pharmacological name)</th>
                        <th>Formulations / Strength</th>
                        <th>Status</th>
                        <th>
                            <span>
                            <a class="btn btn-success add-values btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                            </span>                
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="Name" data-nameLen="1" value="" class="form-control input-fields-shadow input-width-medium valid" /></td>
                        <td><input type="text" name="generic_name" value="" class=" form-control input-fields-shadow "></td>
                        <td><input type="text" name="Value[]" value="" class="form-control input-fields-shadow input-width-medium valid" /></td>
                        <td>
                            <select name="Status[]" class="form-control input-fields-shadow input-width-medium">
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
                                <button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium">
                                <i class="fa fa-floppy-o"></i> Save
                                </button>
                                <a href="{{ action('Masters\DrugController@index') }}" class="btn btn-default btn-basic-shadow form-control input-width-medium" onclick="$('form')[0].reset();">
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
    </div>
    <!-- /.col-md-12 -->                  
</div>
<!-- /.row -->
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
    
        $('.btn.btn-primary').on('click', function(event) {
    
            $('#checkform input.valid').each(function() {
                console.log($(this).attr('name'));
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