<div class="modal fade " id="episodes" role="dialog">
  <div class="modal-dialog">
{!! Form::model(null,['method' => 'GET','url' => action('ProblemBaseDaycare\ProblemPostnatalController@show',$id),'id'=> 'daycare-form']) !!}
 
    <div class="modal-content">
      <div class="modal-header problem-modal-header">
          <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
          <h4 id="myModalLabel" class="modal-title color-white"> Problems List</h4>
      </div>
      <div class="modal-body row row-spacing">
        <div class="col-md-12">
          <div class="col-md-12 form-group">
            {!! Form::label('problem_id','Problems:') !!}
            {!! Form::select('problem_id',$problemLists,null,['class'=>'col-md-12 full-width-fix input-fields-shadow']) !!}
          </div>
        </div>
      </div>    
      <div class="modal-footer">
        <button class="btn btn-primary btn-basic-shadow add-problem"> {{ $SubmitButtonText }}</button>
      </div>  
    </div>
  {!! Form::close(); !!}
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('.add-problem').attr("disabled", true);
    $('#problem_id').change(function() {
      var problem_id = $('#problem_id').val();
      if (problem_id != 0) {
        $('.add-problem').attr("disabled", false);
      } else {
        $('.add-problem').attr("disabled", true);        
      }
    });
  });
</script>
