@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <a href="{{ url('/') }}"><i class="icon-home"></i> Dashboard</a>
        </li>
        <li>
            <a href="{{ action('Masters\DasiiquestionsController@index') }}">DASII Questions</a>
        </li>
        <li class="current">
            <a>Create</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
    <!-- <div class="master-layout"> -->
        {!! Form::open(['url' => action('Masters\DasiiquestionsController@store'),'id'=> 'checkform']) !!}
        <div class="col-md-12 overflow-auto">
            <table class="master_dasii_qestions_table multi-row table table-add-more full-width-fix">
                <thead>
                    <tr>
                        <th width="30">Question</th>
                        <th class="text-center">Question Type</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">50 %</th>
                        <th class="text-center">3 %</th>
                        <th class="text-center">97 %</th>
                        <th class="text-center">Content Cluster</th>
                        <th>
                            <span>
                            <a class="btn btn-success master_dasii_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                            </span>                
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {!! Form::select('',ValuelistHelpers::dasiiQuestionTypes(),null,['class'=>'hide temp_dassi_question_type']) !!}
                    {!! Form::select('',ValuelistHelpers::getContentCluster(),null,['class'=>'hide temp_dasii_content_cluster']) !!}
                    <input type="hidden" name="tablename" value="dasii_questions" />
                    <input type="hidden" name="columnname" value="question" />
                    <input type="hidden" name="deletecolumnname" value="is_deleted" />
                    <input type="hidden" name="sortcolumnname" value="id" />
                    <tr data-len="0">
                        <td width="30%">
                            <textarea class="form-control valid" name="question[]" rows="2" cols="50"></textarea>
                        </td>
                        <td>
                            {!! Form::select('question_type[]',ValuelistHelpers::dasiiQuestionTypes(),null,['class'=>'form-control']) !!}
                        </td>
                        <td>
                            <select name="status[]" class="form-control input-fields-shadow input-width-medium">
                                <option selected="selected" value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="fiftieth_percentile[]" class="form-control" required />
                        </td>
                        <td>
                            <input type="text" name="third_percentile[]" class="form-control" />
                        </td>
                        <td>
                            <input type="text" name="ninety_seventh_percentile[]" class="form-control" />
                        </td>
                        <td>
                            {!! Form::select('content_cluster[]',ValuelistHelpers::getContentCluster(),null,['class'=>'form-control']) !!}
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
                                <a href="{{ action('Masters\DasiiquestionsController@index') }}" class="btn btn-basic-shadow btn-default form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        {!! Form::close() !!}
    <!-- </div> -->
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