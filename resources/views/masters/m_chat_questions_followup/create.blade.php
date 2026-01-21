@extends('app')
@section('content')
<style type="text/css">
    .sortableLists li
    {
        list-style-type: none;
        padding: 10px;
        margin-top: 10px;
        background-color: #1e1e2d;
        color: #fff;
        box-shadow: 0px 0px 6px 0px #555;
    }
    .sortableLists li ol li
    {
        background-color: #3968C6;
    }
    .sortableLists li ol li ol li
    {
        background-color: #888;
    }
    .master-question-input{
        display:none;
    }
    .master-question-input + label {
        margin: 0px 5px;
        display: inline-block;
        width: 48px;
        height: 47px;
        text-align: center;
        border: 1px solid #aaa;
        border-radius: 50%;
        vertical-align: middle;
        padding: 13px 9px;
        box-shadow: 0px 0px 3px #444;
    }
    .master-question-input:checked + label {
        display: inline-block;
        background-color: #434468;
        color: #fff;
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ action('Masters\MchatfollowupquestionsController@index') }}">M-CHAT-R Followup Questions</a>
        </li>
        <li class="current">
            <a>Create</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row mt-20">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-success add_question"><i class="fa fa-plus-circle"></i> ADD QUESTION</button>
    </div>
</div>
<!-- <div class="row row-spacing select-container-main">
    <div class="master-layout">
        <ul class="sortableLists">
            
        </ul>
    </div>
</div> -->
<div class="row row-spacing select-container-main">
    <div class="master-layout">
        <ul class="sortableLists">
            <?php 
                function showQuestions($questions, $parent_id = 0)
                {

                    $cate_child = array();
                    
                    foreach ($questions as $key => $item)
                    {
                        
                        if ($item['parent_id'] == $parent_id)
                        {
                            $cate_child[] = $item;
                            unset($questions[$key]);
                        }
                    }
                     
                 
                    if ($cate_child)
                    {                         
                        echo '<ol>';
                        foreach ($cate_child as $key => $item)
                        {

                            echo '<li id="'.$item['id'].'">'.$item['question'];

                            showQuestions($questions, $item['id']);
                            echo '</li>';
                        }
                        echo '</ol>';
                    }
                }
                showQuestions($questions);
            ?>
                    
        </ul>
    </div>
</div>

<!-- /.row -->
<div class="modal fade flow-control-modal" id="question-modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center text-white">Add Question</h3>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body question-modal-body">
                <div class="form-group row mt-20">
                    <div class="col-md-3 text-right label-control">
                        <label for="question">Question</label>
                    </div>
                    <div class="col-md-9 custom-input" style="padding-right: 40px;">
                        <textarea class="form-control" id="question-input" rows="5"></textarea>
                        <label class="error question-input-error"></label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        <label for="answer">Correct Answer</label>
                    </div>
                    <div class="col-md-9 custom-input">
                        <input type="radio" name="answer-input" class="master-question-input" id="checkbox-button-opt-yes" value="Yes" />
                        <label for="checkbox-button-opt-yes">Yes</label>
                        <input type="radio" name="answer-input" class="master-question-input" id="checkbox-button-opt-no" value="No" />
                        <label for="checkbox-button-opt-no">No</label>
                        <br />
                        <label class="error correct-answer-error"></label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 text-right label-control">
                        <label for="answer">Question Type</label>
                    </div>
                    <div class="col-md-9 custom-input">
                        <input type="radio" name="answer_based_type" class="master-question-input" id="checkbox-button-opt-qt-y" value="Yes" />
                        <label for="checkbox-button-opt-qt-y">Yes</label>
                        <input type="radio" name="answer_based_type" class="master-question-input" id="checkbox-button-opt-qt-n" value="No" />
                        <label for="checkbox-button-opt-qt-n">No</label>
                        <input type="radio" name="answer_based_type" class="master-question-input" id="checkbox-button-opt-qt-g" value="General" />
                        <label for="checkbox-button-opt-qt-g">Both</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: white;">
                <div class="row mx-0">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-theme-primary" id="save-question"><i class="fa fa-save"></i> Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript" src="{{ url('/') }}/public/js/jquery-sortable-lists.min.js"></script>
<script type="text/javascript" src="{{ url('/') }}/public/js/jquery-sortable-lists-mobile.min.js"></script>
<script type="text/javascript">
    var options = {
        currElClass: 'currElemClass',
        currElCss: {'background-color':'green', 'color':'#fff'},
        placeholderClass: 'placeholderClass',
        placeholderCss: {'background-color':'yellow'},
        hintClass: 'hintClass',
        hintCss: {'background-color':'green', 'border':'1px dashed white'},
        listSelector: 'ol',
        hintWrapperClass: 'hintClass',
        complete: function(currEl)
        {
            var parent_ques_id = currEl.parent('ol').parent().closest('li').attr('id');
            var current_question = currEl.attr('id');
            if (parent_ques_id != current_question && parent_ques_id !== undefined && current_question !== undefined) {
                updateQuestionParent(parent_ques_id, current_question);
            }

        }
    };
    $('.sortableLists').sortableLists(options);
    $(document).on('click', '.add_question', function(e)
    {
        $('.question-modal-body textarea').val('');
        $('.question-modal-body input').prop('checked', false);
        $('#question-modal').modal({backdrop: 'static', show: true });
        $('.question-input-error, .correct-answer-error').text('');
    });
    $(document).on('click', '#save-question', function(e)
    {
        e.preventDefault();
        var question        = $('#question-input').val();
        var correct_answer  = $('input[name=answer-input]:checked').val();
        if (!question || question == '' || question == null) {
            $('#question-input').focus();
            $('.question-input-error').text('Enter Question...');
            return false;
        }
        if (!correct_answer || correct_answer == '' || correct_answer == null) {
            $('.correct-answer-error').text('Select answer of this question...');
            return false;
        }

        var question_type = $('input[name=answer_based_type]:checked').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'{{ action("Masters\MchatfollowupquestionsController@store") }}',
            data: {question: question, correct_answer: correct_answer, question_type: question_type},
            beforeSend:function() {
                $('#save-question').prop('disabled', true).html('<i class="fas fa-spinner fa-pulse"></i> Please wait....');
            },
            success:function(response) {
                Showalert('success', 'Question added successfully');
            },
            complete:function(response) {
                // $('#save-question').prop('disabled', false).html('<i class="fas fa-spinner fa-pulse"></i> Please wait....');
                window.location.reload();
            },

            error:function(response) {
                $('#page-loader').hide();
                if (typeof response.responseJSON.message != 'undefined') {
                    var message = response.responseJSON.message;
                    Showalert('error',message);
                }
            }
            
        });

    });
    function updateQuestionParent(parent_id, ques_id)
    {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'{{ action("Masters\MchatfollowupquestionsController@updateParent", "0") }}',
            data: {id: ques_id, parent_id: parent_id},
            beforeSend:function() {
                // $('#save-question').prop('disabled', true).html('<i class="fas fa-spinner fa-pulse"></i> Please wait....');
            },
            success:function(response) {
                
                Showalert('success', 'Question added successfully');
                
            },
            complete:function(response) {
                // $('#save-question').prop('disabled', false).html('<i class="fas fa-spinner fa-pulse"></i> Please wait....');
            },

            error:function(response) {
                $('#page-loader').hide();
                if (typeof response.responseJSON.message != 'undefined') {
                    var message = response.responseJSON.message;
                    Showalert('error',message);
                }
            }
            
        });
    }
</script>
@endsection