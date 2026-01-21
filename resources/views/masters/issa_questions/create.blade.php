@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <a href="{{ url('/') }}"><i class="icon-home"></i> Dashboard</a>
        </li>
        <li>
            <a href="{{ action('Masters\ISSAQuestionsController@index') }}">ISSA Questions</a>
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
        {!! Form::open(['url' => action('Masters\ISSAQuestionsController@store'),'id'=> 'checkform']) !!}
        <div class="col-md-12 overflow-auto">
            <table class="master_issa_qestions_table multi-row table table-add-more full-width-fix">
                <thead>
                    <tr>
                        <th width="30">Question</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Status</th>
                        <th>
                            <span>
                            <a class="btn btn-success master_issa_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                            </span>                
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {!! Form::select('',ValuelistHelpers::issaQuestionTypes(),null,['class'=>'hide temp_issa_question_type']) !!}
                    <tr data-len="0">
                        <td width="30%">
                            <textarea class="form-control valid input-width-medium" name="question[]" rows="2" cols="50"></textarea>
                        </td>
                        <td class="text-center">
                            {!! Form::select('category[]',ValuelistHelpers::issaQuestionTypes(),null,['class'=>'form-control input-width-medium']) !!}
                        </td>
                        <td class="text-center">
                            <select name="status[]" class="form-control input-fields-shadow input-width-small">
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
                                <a href="{{ action('Masters\ISSAQuestionsController@index') }}" class="btn btn-basic-shadow btn-default form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
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