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
            <a href="{{ action('Masters\MchatquestionsController@index') }}">M-CHAT-R Questions</a>
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
        {!! Form::open(['url' => action('Masters\MchatquestionsController@store'),'id'=> 'checkform']) !!}
        <div class="col-md-12 overflow-auto">
            <table class="master_m_chat_qestions multi-row table table-add-more full-width-fix">
                <thead>
                    <tr>
                        <th width="50">Question</th>
                        <th class="text-center">Answer</th>
                        <th class="text-center">Status</th>
                        <th>
                            <span>
                            <a class="btn btn-success master_m_chat_questions_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                            </span>                
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <input type="hidden" name="tablename" value="m_chat_r_questions" />
                    <input type="hidden" name="columnname" value="question" />
                    <input type="hidden" name="columnname_5" value="correct_answer" data-field-name="answer" />
                    <input type="hidden" name="deletecolumnname" value="is_deleted" />
                    <input type="hidden" name="sortcolumnname" value="id" />
                    <tr data-len="0">
                        <td width="50%">
                            <textarea class="form-control valid" name="question[]" rows="5" cols="50"></textarea>
                        </td>
                        <td>
                        	<input data-size="small" name="answer[]" data-off="No" data-on="Yes" data-width="100" data-toggle="toggle" class="form-control switch-input" type="checkbox" />
                        </td>
                        <td>
                            <select name="status[]" class="form-control input-fields-shadow input-width-medium">
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
                                <a href="{{ action('Masters\MchatquestionsController@index') }}" class="btn btn-basic-shadow btn-default form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
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