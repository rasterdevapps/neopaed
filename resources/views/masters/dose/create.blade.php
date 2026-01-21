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
            <a href="{{ action('Masters\DoseController@index') }}">Dose</a>
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
        {!! Form::open(['url' => action('Masters\DoseController@store'),'id'=> 'checkform']) !!}
        {!! Form::hidden('Id',null,['class'=>'form-control','id'=>'Id']) !!}
        <div class="col-md-12 overflow-auto">
            <table class="master_dose multi-row table table-add-more full-width-fix">
                <thead>
                    <tr>
                        <th>Volume</th>
                        <th>Status</th>
                        <th>
                            <span>
                            <a class="btn btn-success master_dose_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                            </span>                
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" name="tablename" value="mas_dose" />
                    <input type="hidden" name="columnname" value="volume" />
                    <input type="hidden" name="deletecolumnname" value="is_deleted" />
                    <input type="hidden" name="sortcolumnname" value="id" />
                    <tr data-len="0">
                        <td><input type="text" name="volume[]" value="" class="form-control input-fields-shadow input-width-medium valid" /></td>
                        <td>
                            <select name="status[]" class="form-control input-fields-shadow input-width-medium">
                                <option selected="selected" value="1">Active</option>
                                <option value="0">Inactive</option>
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
                                <a href="{{ action('Masters\DoseController@index') }}" class="btn btn-basic-shadow btn-default form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
    
      $.validator.addClassRules("valid", {
            required: true,
            samevalue: true,
            alreadyexists: true,
        });  
        $('#checkform .btn.btn-primary').on('click', function(event) {

            $("#checkform").validate({
                onfocusout: false,
                onkeyup: false,
                submitHandler: function(form) {
                    $(this).prop('disabled', true);
                    $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
                    form.submit();
                }
            });
            
        });
    
    });
</script>
@endsection