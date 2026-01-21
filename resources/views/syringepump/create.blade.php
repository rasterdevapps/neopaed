
<div class="modal fade syringepump-model" id="syringepump-model" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="modal-header bg-white">
        <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>  
        <h5 class="modal-title"><h3>Welcome To Neopaed Nurse</h3></h5>
       </div>
       <div class="modal-body">
         <div class="row row-spacing">
              <div class="col-md-12">
              {!! Form::model(null,['url' => action('Syringepump\SyrangePumpController@store'),'id'=>'nurse-daycare']) !!}
              @include('errors.list')
                <div role="tabpanel" class="tabbable tabbable-custom">
                      <ul class="nav nav-tabs hide" role="tablist">
                        <li role="presentation" class="active">
                          <a href="#sheet1" role="tab" data-toggle="tab">Sheet 1</a>
                        </li>
                      </ul> 
                        <!-- Tab panes -->
                      <div class="tab-content tab-view-shadow">
                              <!-- General Form -->
                         <div role="tabpanel" class="tab-pane active" id="sheet1">
                          <div class="col-md-12">
                            <div class="col-md-6">
                              <div class="form-group">
                                {!! Form::label('BMrNo','Baby\'s '. Lang::get('home.mrn') .'.:') !!}
                                <br/>
                                {!! Form::Select('BMrNo',$baby_list,null,['class'=>'select2-select-00 width-500']) !!}
                              </div>
                            </div>
                            <div class="col-md-6">
                               <div class="form-group">
                                {!! Form::label('transfer_status','Transfer Status:') !!}
                                {!! Form::Select('transfer_status',$transfer_status,null,['class'=>'form-control']) !!}
                              </div>
                            </div>
                          </div>
                         </div>
                        <div class="row col-md-11">
                          <div class="col-md-3">
                              <button type="button" onclick="$('#print_flag').val('1'); $(form).submit();" class="btn save-button-shadow btn-primary form-control"><i class="fa fa-floppy-o"></i>
                                  <span>Print</span>
                              </button>
                          </div>
                          <div class="col-md-3">
                              <input type="hidden" name="print_flag" value="0" id="print_flag"/>
                                <button type="button" class="btn btn-block save-button-shadow btn-info form-control" onclick="$('#print_flag').val('2'); $(form).submit();">
                                      <i class="fa fa-print"></i>
                                       <span>Save</span>
                                </button>
                          </div>
                          <div class="col-md-3">
                              <a href="{{ action('Syringepump\SyrangePumpController@index') }}" class="btn  save-button-shadow btn-default form-control" onclick="$('form')[0].reset();">
                                <i class="fa fa-exclamation-circle"></i> 
                                <span>Cancel</span>
                              </a>
                          </div>
                        </div> 
                      </div>
                </div>
              </div>
            </div>
          </div>   
      </div>
    </div>
</div>
 
