<div class="modal fade" id="complaints-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="create">New Complaint</h3>
                    <h3 class="edit">Update Complaint</h3>
                </h5> 
                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="font-size-one">&times;</span>
                </button> 
            </div>
            <div class="modal-body row">
                <form class="col-md-12 complaint-form">
                    {{ Form::text('title',null,['class'=>'form-control sub','placeholder'=>'Subject','id'=>'title']) }}
                    {{ Form::label('made_by','Issue made by') }}
                    {{ Form::select('made_by',['Human_error'=>'User','System_error'=>'System'],null,['class'=>'form-control']) }}
                    {{ Form::label('user_list','Users') }}
                    {{ Form::select('user_list',[],null,['class'=>'form-control']) }}                   
                    {{ Form::label('description','Description') }}
                    {{ Form::textarea('description',null,['class'=>'form-control','rows'=>'3']) }}              
                <div class="edit">
                    <div class="col-md-12 remove-padding">
                        {{ Form::label('status','Status:') }}
                    </div>
                    <div class="col-md-12">
                        {{ Form::radio('Status','Open') }}                  
                        {{ Form::label('Open','Open') }}
                        {{ Form::radio('Status','Pending') }}
                        {{ Form::label('Pending','Pending') }}
                        {{ Form::radio('Status','Completed') }}
                        {{ Form::label('Completed','Completed') }}
                        {{ Form::radio('Status','Not a issue') }}
                        {{ Form::label('Not_a_issue','Not a issue') }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary create" type="submit" id="form_save">Send</button>
                <button class="btn btn-primary edit" type="submit" id="form_update">Update</button>                    
                <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>