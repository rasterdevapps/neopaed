<div class="modal fade flow-control-modal" id="mrn-input-model" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="text-center text-white">Please enter UHID</h3>
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="mt-10">
                        {!! Form::text('uhid', null, ['class'=>'form-control']) !!}
                        <span id="uhid_no_error" class="hide error-message">* Required</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: white;">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="mt-10">
                        <button type="button" class="btn btn-primary btn-shadow-special" id="uhid-save" data-dismiss="static" aria-label="Close">Save</button>
                        <button type="button" class="btn btn-default btn-shadow-special" data-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>