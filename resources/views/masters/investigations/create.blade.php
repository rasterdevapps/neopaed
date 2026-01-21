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
            <a href="{{ action('Masters\InvestigationsController@index') }}">Investigations</a>
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
        {!! Form::open(['url' => action('Masters\InvestigationsController@store'),'id'=> 'checkform']) !!}
        {!! Form::hidden('Id',null,['class'=>'form-control','id'=>'Id']) !!}
        <div class="col-md-12 overflow-auto">
            <table class="master_investigations multi-row table table-add-more full-width-fix">
                <thead>
                    <tr>
                        <th>Package Name</th>
                        <th>Package Status</th>
                        <th>Test Name</th>
                        <th>Test Status</th>
                        <th>
                            <span>
                            <a class="btn btn-success master_investigations_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                            </span>                
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-len="0">
                        <td>
                            <input type="text" name="package_name" value="" class="form-control input-fields-shadow input-width-large name"/>
                        </td>
                        <td>
                            <select name="package_status" class="form-control input-fields-shadow input-width-medium">
                                <option selected="selected" value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="test_name[]" value="" class="form-control input-fields-shadow input-width-medium name" />
                        </td>
                        <td>
                            <select name="test_status[]" class="form-control input-fields-shadow input-width-medium">
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
                        <td colspan="5">
                            <div class="master-btn-layout">
                                <button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium"><i class="fa fa-floppy-o"></i> Save</button>
                                <a href="{{ action('Masters\InvestigationsController@index') }}" class="btn btn-basic-shadow btn-default form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
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
